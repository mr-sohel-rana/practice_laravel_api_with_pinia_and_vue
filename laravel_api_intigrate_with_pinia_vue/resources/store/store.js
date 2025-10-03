import { defineStore } from "pinia";
import api from "./service";

export const useCrudStore = defineStore("crud", {
    state: () => ({
        posts: [],
        post: "",
        loading: false,
        error: null,
    }),
    actions: {
        async index() {
            this.loading = true;
            this.error = null;
            try {
                const res = await api.getProducts();
                this.posts = res.data.product;
            } catch (err) {
                this.error = err.response?.data || err.message;
            } finally {
                this.loading = false;
            }
        },
        async show(id) {
            this.loading = true;
            this.error = null;
            try {
                const res = await api.getProduct(id);
                this.post = res.data.product;
            } catch (err) {
                this.error = err.response?.data || err.message;
            } finally {
                this.loading = false;
            }
        },

        async store(data) {
            try {
                const res = await api.createProduct(data);
                this.posts.push(res.data.product);
            } catch (err) {
                console.error(err);
            }
        },

        async update(id, data) {
            try {
                const res = await api.updateProduct(id, data);
                const index = this.posts.findIndex((p) => p.id === id);
                if (index !== -1) this.posts[index] = res.data.product;
            } catch (err) {
                console.error(err);
            }
        },

        async destroy(id) {
            try {
                await api.deleteProduct(id);
                this.posts = this.posts.filter((p) => p.id !== id);
            } catch (err) {
                console.error(err);
            }
        },
    },
});
