 import axios from "axios";

const api = axios.create({
    baseURL: "http://127.0.0.1:8000/api",
});

// Get all images
export default {
    getProducts() {
        return api.get("/images");
    },

    getProduct(id) {
        return api.get(`/image/${id}`);
    },

    // Create new image
    createProduct(data) {
        return api.post("/addImage", data, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
    },

    // Update existing image
    // service.js
updateProduct(id, data) {
    // Use POST with _method=PUT
    data.append('_method', 'PUT');
    return api.post(`/updateImage/${id}`, data, {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });
},


    deleteProduct(id) {
        return api.delete(`/deleteImage/${id}`);
    },
};
