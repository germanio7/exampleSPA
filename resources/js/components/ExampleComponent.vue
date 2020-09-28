<template>
    <div class="flex justify-center">
        <div class="w-full max-w-xs mt-8">
            <form
                @submit.prevent="login()"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
            >
                <div class="mb-4">
                    <label
                        class="block text-gray-700 text-sm font-bold mb-2"
                        for="email"
                    >
                        Email
                    </label>
                    <input
                        v-model="form.email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="email"
                        type="text"
                        placeholder="Email"
                    />
                </div>
                <div class="mb-6">
                    <label
                        class="block text-gray-700 text-sm font-bold mb-2"
                        for="password"
                    >
                        Password
                    </label>
                    <input
                        v-model="form.password"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="password"
                        type="password"
                        placeholder="******************"
                    />
                    <p
                        v-if="errors.length > 0"
                        class="text-red-500 text-xs italic"
                    >
                        {{ errors.email[0] }}
                    </p>
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit"
                    >
                        Login
                    </button>
                    <button
                        type="button"
                        @click="getUser()"
                        class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    >
                        User
                    </button>
                    <button
                        @click="logout()"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button"
                    >
                        Logout
                    </button>
                </div>
            </form>

            <p class="text-center text-gray-500 text-xs">
                &copy;2020 Test
            </p>
        </div>
    </div>
</template>

<script>
import axios from "axios";
axios.defaults.withCredentials = true;

export default {
    data() {
        return {
            form: {
                email: "",
                password: ""
            },
            errors: {},
            token: ""
        };
    },

    methods: {
        login() {
            axios
                .post("api/login", this.form)
                .then(res => {
                    this.token = res.data;
                    console.log(this.token);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        logout() {
            axios.post("api/logout", this.form).then(res => {
                this.token = "";
            });
        },

        getUser() {
            axios.defaults.headers.common = {
                Authorization: "Bearer " + this.token
            };
            axios.get("api/user").then(res => {
                console.log(res);
            });
        }
    }
};
</script>
