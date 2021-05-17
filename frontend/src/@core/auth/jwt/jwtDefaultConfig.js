export default {
  // Endpoints
  loginEndpoint: '/api/v1/shop/login',
  registerEndpoint: '/api/v1/shop/register',
  refreshEndpoint: '/api/v1/shop/refresh-token',
  logoutEndpoint: '/api/v1/shop/logout',

  // This will be prefixed in authorization header with token
  // e.g. Authorization: Bearer <token>
  tokenType: 'Bearer',

  // Value of this property will be used as key to store JWT token in storage
  storageTokenKeyName: 'userAccessToken',
  storageRefreshTokenKeyName: 'userRefreshToken',
}
