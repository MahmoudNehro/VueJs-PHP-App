import http from "../http-requests";

class RequestServiceClass {
    getAll() {
        return http.get("/products");
    }
    create(data) {
        return http.post("/products", { category_id:2, name: "test", price: 100 });
    }
    massDelete(ids) {
        return http.delete("/products/delete", {params: {product_ids: ids}});
    }
    getAllCategories() {
        return http.get("/categories");
    }


}

export default new RequestServiceClass();
