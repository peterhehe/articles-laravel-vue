<template>
<div class="container">
    <div class="card border-primary">
        <div class="card-header">
            <h3 class ='text-secondary'>View Article</h3>
        </div>
        <div class="card-body bg-light">
            <div class="row text-left">
                <div class="col-md-12">
                    <h3>{{data.title}}</h3>
                </div>
            </div>
            <br>
            <br>
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <p style="white-space: pre-line;">{{data.content}}</p>
                </div>
            </div>
            <br>
            <div class="row text-center">
                <div class="col-sm-12" v-if="data.title">
                    <img :src="('storage/images/'+data.photo)" style ="display: block; margin-left: auto; margin-right: auto; width: 50%;"  alt="image">
                </div>
            </div>
            <br>
            <div class="tags-input-container">
                <div class="tag-view" v-for="(tag, index) in data.tags">
                    <span>#{{tag}}</span>
                </div>
                <br>
                <br>
            </div>
            <br>
            <div class="row text-right">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-outline-dark" v-on:click="showTable">Back</button>
                    </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['data'],

        data() {
            return {
             
            }
        },
        methods: {
            showTable(){
                this.$emit('showTable')
            }
        }
    }
</script> 

<style lang="scss">
    .tag-view {
        float: left;
        padding: 3px 5px;
        display:flex;
        justify-content: center;
        cursor: pointer;
        background-color: #81d8d0;
        border-radius: 5px;
        margin-right: 8px;

        &:hover {
            background-color: #66cccc;
        }
        
        span:first-child {
            margin-right: 8px;
        }
    }

</style>