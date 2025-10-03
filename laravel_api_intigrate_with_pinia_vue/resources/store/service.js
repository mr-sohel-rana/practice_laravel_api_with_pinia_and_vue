import axios from "axios";
const api = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        "Content-Type": "application/json",
    },
});

export default {
    getProducts() {
        return api.get("/product");
    },

    getProduct(id) {
        return api.get(`/product/${id}`);
    },
    createProduct(data) {
        return api.post("/product", data);
    },

    updateProduct(id, data) {
        return api.put(`/product/${id}`, data);
    },

    deleteProduct(id) {
        return api.delete(`/product/${id}`);
    },
};
