import axios from "axios";

export default axios.create({
  baseURL: "http://onlinecrudapimahmoud.medianewsonline.com",
  headers: {
    "Content-type": "application/json",
  }
});
