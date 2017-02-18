// import localStorage from 'vue-localstorage';
import axios from 'axios';

export default class {

    static get () {
        // let storage = new localStorage();
        // let token = storage.get('jwt-token');
        // return 'token';

        return axios.get('token')
        .then((response) => {
            return response.data.token;
        });
    }

}