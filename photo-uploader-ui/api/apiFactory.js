
import $axios from './apiClient';
import axiosInstance from './autenticatedClient';

export const api = (resource) => {
  const defaultRepoMethods = {
    all: (query = {}, page = null, pageSize = null, resourceUri = resource) => {
      let params = {};

      // Parse filters
      const filters = {};
      if (query.filter) {
        Object.keys(query.filter).forEach((key) => {
          filters[`filter[${key}]`] = query.filter[key];
        });

        params = { ...params, ...filters };
      }

      if (query.sort) {
        params.sort = query.sort;
      }

      if (query.group) {
        params.groupBy = query.group;
      }

      for (const [queryKey, queryValue] of Object.entries(query)) {
        if (!['filter', 'sort', 'group'].includes(queryKey)) {
          params[queryKey] = queryValue;
        }
      }

      // Pagination request
      if (page) {
        params.page = page;
      }

      if (pageSize) {
        params.pageSize = pageSize || 20;
      }

      // Regular request
      return $axios.$get(resourceUri, { params });
    },

    get: id => $axios.$get(`${resource}/${id}`),

    create: payload => $axios.$post(resource, payload),

    update: (id, payload) => $axios.$patch(`${resource}/${id}`, payload),

    delete: ({ id }) => $axios.$delete(`${resource}/${id}`)
  };

  const repositories = {
    'auth': {
      login: (payload) => $axios.post(`${resource}/login`, payload),
      register: (payload) => $axios.post(`${resource}/registration`, payload),
      logout: () => $axios.post(`${resource}/logout`),
      me: () => axiosInstance.get(`${resource}/me`),
    },
  };

  if (Object.prototype.hasOwnProperty.call(repositories, resource)) {
    return repositories[resource];
  }

  throw new Error(`API repository for resource "${resource}" doesn't exist.`);
};
