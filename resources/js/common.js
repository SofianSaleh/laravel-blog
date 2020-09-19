import Axios from "axios";

export default {
    data() {
        return {};
    },
    methods: {
        async callApi(method, url, data) {
            try {
                return await Axios({
                    method,
                    url,
                    data
                });
            } catch (e) {
                return e.response;
            }
        }
    }
};
