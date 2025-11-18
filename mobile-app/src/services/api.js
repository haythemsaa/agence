import axios from 'axios';
import AsyncStorage from '@react-native-async-storage/async-storage';

// Base URL - Change this to your Laravel backend URL
const BASE_URL = __DEV__
  ? 'http://10.0.2.2:8000/api' // Android Emulator
  : 'https://your-domain.com/api'; // Production

// Create axios instance
const apiClient = axios.create({
  baseURL: BASE_URL,
  timeout: 15000,
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
});

// Request interceptor - Add auth token
apiClient.interceptors.request.use(
  async config => {
    const token = await AsyncStorage.getItem('auth_token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  },
);

// Response interceptor - Handle errors
apiClient.interceptors.response.use(
  response => response.data,
  async error => {
    if (error.response?.status === 401) {
      // Token expired or invalid
      await AsyncStorage.removeItem('auth_token');
      await AsyncStorage.removeItem('user');
      // Navigate to login screen
    }
    return Promise.reject(error);
  },
);

// API Methods
export const api = {
  // Auth
  auth: {
    login: (credentials) => apiClient.post('/login', credentials),
    register: (data) => apiClient.post('/register', data),
    logout: () => apiClient.post('/logout'),
    me: () => apiClient.get('/user'),
    updateProfile: (data) => apiClient.put('/user/profile', data),
  },

  // Hotels
  hotels: {
    getAll: (params) => apiClient.get('/hotels', {params}),
    getById: (id) => apiClient.get(`/hotels/${id}`),
    search: (query) => apiClient.get('/hotels/search', {params: query}),
    getFeatured: () => apiClient.get('/hotels/featured'),
  },

  // Packages
  packages: {
    getAll: (params) => apiClient.get('/packages', {params}),
    getById: (id) => apiClient.get(`/packages/${id}`),
    getBySlug: (slug) => apiClient.get(`/packages/${slug}`),
    search: (query) => apiClient.get('/packages/search', {params: query}),
    getFeatured: () => apiClient.get('/packages/featured'),
    getByType: (type) => apiClient.get(`/packages/type/${type}`),
  },

  // Bookings
  bookings: {
    create: (data) => apiClient.post('/bookings', data),
    getAll: () => apiClient.get('/bookings'),
    getById: (id) => apiClient.get(`/bookings/${id}`),
    cancel: (id) => apiClient.post(`/bookings/${id}/cancel`),
  },

  // Reviews
  reviews: {
    create: (data) => apiClient.post('/reviews', data),
    getByHotel: (hotelId) => apiClient.get(`/hotels/${hotelId}/reviews`),
    getByPackage: (packageId) => apiClient.get(`/packages/${packageId}/reviews`),
    getRecent: () => apiClient.get('/reviews/recent'),
  },

  // Wishlist
  wishlist: {
    getAll: () => apiClient.get('/wishlist'),
    add: (data) => apiClient.post('/wishlist', data),
    remove: (id) => apiClient.delete(`/wishlist/${id}`),
    toggle: (data) => apiClient.post('/wishlist/toggle', data),
  },

  // Payment
  payment: {
    initiate: (data) => apiClient.post('/payment/initiate', data),
    verify: (data) => apiClient.post('/payment/verify', data),
    getMethods: () => apiClient.get('/payment/methods'),
  },

  // Loyalty
  loyalty: {
    getPoints: () => apiClient.get('/loyalty/points'),
    getHistory: () => apiClient.get('/loyalty/history'),
    redeem: (data) => apiClient.post('/loyalty/redeem', data),
  },

  // Referrals
  referrals: {
    getCode: () => apiClient.get('/referrals/code'),
    getStats: () => apiClient.get('/referrals/stats'),
    getReferrals: () => apiClient.get('/referrals'),
  },

  // Gift Vouchers
  vouchers: {
    purchase: (data) => apiClient.post('/gift-vouchers/purchase', data),
    check: (code) => apiClient.get(`/gift-vouchers/check/${code}`),
    getAll: () => apiClient.get('/gift-vouchers'),
  },

  // Destinations
  destinations: {
    getAll: () => apiClient.get('/destinations'),
    getPopular: () => apiClient.get('/destinations/popular'),
  },

  // Blog
  blog: {
    getAll: (params) => apiClient.get('/blog', {params}),
    getById: (id) => apiClient.get(`/blog/${id}`),
    getRecent: () => apiClient.get('/blog/recent'),
  },

  // Notifications
  notifications: {
    getAll: () => apiClient.get('/notifications'),
    markAsRead: (id) => apiClient.post(`/notifications/${id}/read`),
    markAllAsRead: () => apiClient.post('/notifications/read-all'),
  },
};

// Helper functions
export const setAuthToken = async (token) => {
  await AsyncStorage.setItem('auth_token', token);
};

export const removeAuthToken = async () => {
  await AsyncStorage.removeItem('auth_token');
};

export const getAuthToken = async () => {
  return await AsyncStorage.getItem('auth_token');
};

export default api;
