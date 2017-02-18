import localStorage from 'vue-localstorage';
import axios from 'axios';

export default class JournalClient {

    get () {
        let token = this.$localStorage.get('jwt-token');

        console.log("token in journal class", token);

        return axios.get('/api/journals', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
    }

    store (title) {
        return alert("Make API Call to store new Journal");
    }

    update () {

    }

}