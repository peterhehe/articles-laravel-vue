<template>
<div class="container">
    <div class="row text-right">
        <div class="col-md-12">
            <button type="button" class="btn btn-success btn-md" v-on:click="newArticle">New Article</button>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg">
            <div class="card border-primary">
                <div class="card-header">
                    <div class="container">
                        <div class="row">
                        <div class="col-sm-10">
                        <h3 class ='text-secondary'>List of Articles</h3>
                        </div>
                        <div class="col-sm-2">
                        <div class="input-group mb-3">
                        <input type="text" v-model="limit" class="form-control" placeholder="10" aria-label="Items per page" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button v-on:click="getArticles(limit, 1)" class="btn btn-outline-secondary" type="button">Limit</button>
                        </div>
                        </div>
                        </div>
                        </div>
                </div>
                <div class="card-body bg-light">
                    <table>
                        <thead>
                        <tr>
                            <th width="20%" style='text-align:center'>Title</th>
                            <th width="30%" style='text-align:center'>URL</th>
                            <th width="20%" style='text-align:center'>Date created</th>
                            <th width="20%" style='text-align:center'>Date updated</th>
                            <th width="5%" style='text-align:center'>Published</th>
                            <th width="15%" style='text-align:right'></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="article in articles" :key="article.id">
                            <td width="20%" style='text-align:center'><button type="button" class="btn btn-link" v-on:click="editArticle(article.id)">{{article.attributes.title}}</button></td>
                            <td width="30%" style='text-align:center'><button type="button" class="btn btn-link" :class="{'disabled' :article.attributes.published_at == null}" v-on:click="viewArticle(article.attributes.slugcase)">/api/article/{{article.attributes.slugcase}}</button></td>
                            <td width="20%" style='text-align:center'>{{article.attributes.created_at}}</td>
                            <td width="20%" style='text-align:center'>{{article.attributes.updated_at}}</td>
                            <td width="5%" style='text-align:center'>                       
                                <svg v-if="article.attributes.published_at" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-check-circle" fill="darkgreen" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                                </svg>
                            <td width="15%" style='text-align:right'>
                                <button type="button" class="btn btn-danger">
                                    <svg v-on:click="deleteArticle(article.id)" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="white" fill-opacity="1" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            <pagination-component :meta="meta" v-on:pagination="getArticles"></pagination-component>
    </div>
</div>
</div>
</template>

<script>
    export default {
        data() {
            return {
              articles: {},
              meta: {},
              limit:10,
              data: {}
            }
        },
        methods: {
            getArticles(limit, page){
                axios.get('api/articles',{
                    params: {
                        limit:this.limit,
                        page
                    }
                })
                     .then((response)=>{
                       this.articles = response.data.data.data
                       this.meta = response.data.data
                     })
            },
            viewArticle(slugcase){
                axios.get('api/article/'+slugcase)
                    .then((response)=>{
                        this.$emit('viewArticle', response.data.data.attributes)
                     })
            },
            editArticle(id){
                axios.get('api/article/'+id+'/update')
                    .then((response)=>{
                        this.$emit('viewForm', response.data.data)
                     })
            },
            deleteArticle(id){
                axios.delete('api/article/'+id+'/delete')
                    .then((result)=>{
                        this.getArticles()
                })
            },
            newArticle(){
                this.$emit('newForm')
            },
            
        },
        mounted() {
            this.getArticles();
        },
        watch: {
            'limit': function(val, preVal){
                this.limit = val
            }
        }
    }
</script> 