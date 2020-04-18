<template>
    <div>
        <input v-model="link" placeholder="http://example.com">
        <button @click="createLink">Уменьшить</button>
        <br>
        <input type="checkbox" @click="show_datapicker = !show_datapicker"> Ограничить время жизни
        <div v-if="show_datapicker">
            <datepicker v-model="dead_time" monday-first="true" inline="true"></datepicker>
        </div>
        <div v-if="shorted">
            <input class="shortedInput" v-model="link_short">
        </div>
        <div v-if="err" style="color: red">Ошибка! Проверте поле</div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        components: {
            Datepicker
        },
        data(){
            return {
                dead_time: null,
                shorted: false,
                show_datapicker: false,
                link_short: "",
                link: "",
                err: false,
            }
        },
        mounted() {
            axios.defaults.headers.common["XSRF-TOKEN"] = this.$cookie.get('XSRF-TOKEN');
        },
        methods: {
            createLink() {
                this.err = false;

                let request = {
                    link: this.link
                };

                if (this.show_datapicker) {
                    request.dead_time = this.dead_time;
                }

                axios.post('/create_link',request).then(response => {
                    this.link_short = document.baseURI + "s/" + response.data.key;
                    this.shorted = true;
                    this.link = "";
                }).catch(error => {
                    this.err = true;
                    this.link = "";
                    console.error("Error", error);
                });
            }
        }
    }
</script>

<style scoped>
    .shortedInput {
        width: -moz-available;
        width: -webkit-fill-available;
    }
</style>
