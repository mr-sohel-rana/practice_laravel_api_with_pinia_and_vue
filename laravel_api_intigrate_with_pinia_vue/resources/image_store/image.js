 import { defineStore } from "pinia";
import api from "./service";

export const useImageStore = defineStore("image", {
    state: () => ({
        images: [],
        image: null,
        loading: false,
        error: null,
    }),
    actions: {
        async index() {
            this.loading = true;
            this.error = null;
            try {
                const res = await api.getProducts();
                this.images = res.data; // API response data
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
                this.image = res.data;
            } catch (err) {
                this.error = err.response?.data || err.message;
            } finally {
                this.loading = false;
            }
        },

        async store(data) {
            try {
                const res = await api.createProduct(data);
                this.images.push(res.data); // nested data
            } catch (err) {
                console.error(err);
            }
        },

        async update(id, data) {
    try {
        const res = await api.updateProduct(id, data);
        const index = this.images.findIndex(p => p.id === id);
        if (index !== -1) this.images[index] = res.data.data; // correct
    } catch (err) {
        console.error(err);
    }
},


        async destroy(id) {
            try {
                await api.deleteProduct(id);
                this.images = this.images.filter((p) => p.id !== id);
            } catch (err) {
                console.error(err);
            }
        },
    },
});
