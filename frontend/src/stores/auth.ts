import {defineStore} from 'pinia';
import {computed, ref} from "vue";
import api from '../api';
import {AuthResponse, LoginCredentials, User} from "../types/auth";

export const useAuthStore = defineStore('auth', () => {
    const user = ref<User | null>(null);
    const token = ref<string | null>(localStorage.getItem('access_token'));

    const isLoggedIn = computed(() => !!token.value);

    async function login(credentials: LoginCredentials): Promise<boolean> {
        try {
            const {data} = await api.post<AuthResponse>('login', credentials);
            token.value = data.access_token;
            user.value = data.user;

            localStorage.setItem('access_token', data.access_token);
            return true;
        } catch (error) {
            console.log('Login failed', error);
            throw error;
        }
    }

    function logout(): void {
        token.value = null;
        user.value = null;
        localStorage.removeItem('access_token');
    }

    return {user, token, isLoggedIn, login, logout};
});