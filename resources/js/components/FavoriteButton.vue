<template>
    <div>
        <button class=" btn btn-danger ml-4" @click="favoritePost" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {
        props:['postId', 'favorite'],
        mounted() {
            console.log('Component mounted.')
        },

        data: function () {
            return {
                status: this.favorite,
            }
        },

        methods: {
            favoritePost(){
                axios.post('/favorite/' + this.postId)
                    .then(response => {
                        this.status = ! this.status;

                        console.log(response.data);
                    })
                    .catch(errors => {
                    if(errors.response.status == 401){
                        window.location = '/login';
                    }

                })
            }
        },

        computed: {
            buttonText() {
                return (this.status) ? 'お気に入りを解除' : 'お気に入りに追加';
            }
        }

    }
</script>
