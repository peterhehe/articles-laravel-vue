<template>
<div class="container">
    <table-component v-on:viewArticle="showArticle" v-on:viewForm="showForm" v-on:newForm="newForm" v-show='articleList' :key="renderKey"></table-component>
    <view-component v-on:showTable="showTable" v-show="viewArticle" :data="data"></view-component>
    <form-component v-on:showTable="showTable" v-show="viewForm" :data="data"></form-component>
    <new-form-component v-on:showTable="showTable" v-show="newArticle" :key="renderKey+1"></new-form-component>
</div>
</template>

<script>
 export default {
        data() {
            return {
                articleList: true,
                viewForm: false,
                viewArticle: false,
                newArticle: false,
                data:{},
                renderKey: 1
            }
        },
        methods: {
            showArticle(data) {
                this.data = data
                this.articleList = false
                this.viewForm = false
                this.viewArticle = true
            },
            showTable() {
                this.data = {}
                this.renderKey++
                this.viewForm = false
                this.viewArticle = false
                this.newArticle = false
                this.articleList = true
            },            
            showForm(data) {
                this.data = data.attributes
                this.data.id = data.id
                this.viewForm = true
                this.viewArticle = false
                this.articleList = false
            },
            newForm() {
                this.data = {}
                this.viewForm = false
                this.viewArticle = false
                this.articleList = false
                this.newArticle = true
            }
        }
    }
</script>