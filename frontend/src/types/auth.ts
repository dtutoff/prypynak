export interface User {
  id: number
  name: string
  email: string
}

export interface AuthResponse {
  access_token: string
  token_type: string
  user: User
}

export interface LoginCredentials {
  email: string
  password: string
}
