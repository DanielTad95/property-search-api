import './bootstrap';
import { createApp } from 'vue';
import axios from 'axios';
import ElementPlus from 'element-plus';
import 'element-plus/dist/index.css';

const app = createApp({
    data() {
        return {
            searchParams: {
                name: '',
                bedrooms: null,
                bathrooms: null,
                storeys: null,
                garages: null,
                price_min: null,
                price_max: null
            },
            properties: [],
            loading: false,
            searched: false
        }
    },
    methods: {
        async searchProperties() {
            this.loading = true;
            this.searched = true;
            
            try {
                const params = {};
                Object.keys(this.searchParams).forEach(key => {
                    const value = this.searchParams[key];
                    // Include only non-empty values (not null, not undefined, not empty string, not 0)
                    if (value !== '' && value !== null && value !== undefined && value !== 0) {
                        params[key] = value;
                    }
                });

                const response = await axios.get('/api/properties/search', { params });
                
                if (response.data.success) {
                    this.properties = response.data.data;
                }
            } catch (error) {
                console.error('Search error:', error);
                alert('An error occurred while searching. Please try again.');
            } finally {
                this.loading = false;
            }
        },
        formatPrice(price) {
            return new Intl.NumberFormat('en-US').format(price);
        }
    }
});

app.use(ElementPlus);
app.mount('#app');
