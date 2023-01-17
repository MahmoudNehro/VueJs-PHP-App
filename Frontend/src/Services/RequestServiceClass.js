import http from "../http-requests";

class RequestServiceClass {
    getAll() {
        return http.get("/products");
    }



    create(data) {
        return http.post("/products", data);
    }



    deleteMass(id) {
        return http.delete(`/products/delete/${id=[]}`);
    }


}

export default new RequestServiceClass();
