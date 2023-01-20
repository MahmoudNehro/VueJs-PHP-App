import http from "../http-requests";

class RequestServiceClass {
    getAll() {
        return http.get("/products");
    }
    create(data) {

        const config = {
            headers: {
                "Content-Type": "multipart/form-data",
            },

        };
        return http.post("/products", data, config);
    }
    massDelete(ids) {
        return http.delete("/products/delete", { params: { product_ids: ids } });
    }
    getAllCategories() {
        return http.get("/categories");
    }
    getOneCategory(id) {
        return http.get(`/categories/${id}`);
    }

}

export default new RequestServiceClass();
