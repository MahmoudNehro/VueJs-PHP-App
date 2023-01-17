import http from "../http-requests";

class RequestServiceClass {
    getAll() {
        return http.get("/products");
    }



    create(data) {
        return http.post("/tutorials", data);
    }



    deleteMass(id) {
        return http.delete(`/tutorials/${id}`);
    }


}

export default new RequestServiceClass();
