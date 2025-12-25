import './bootstrap';

// Base API URL
const API_URL = '/api';

// Helper: Get JWT token
function getToken() {
    return localStorage.getItem('token');
}

// Helper: API Request with JWT
async function apiRequest(url, options = {}) {
    const token = getToken();
    const headers = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        ...options.headers
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    return fetch(url, {
        ...options,
        headers
    });
}

// Export for global use
window.API_URL = API_URL;
window.getToken = getToken;
window.apiRequest = apiRequest;

console.log('Fashion Brand App Loaded Successfully ✓');
