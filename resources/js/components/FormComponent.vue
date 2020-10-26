<template>
<div class="container">
    <div class="card border-primary">
        <div class="card-header">
            <h3 class ='text-secondary'>Edit Article</h3>
        </div>
        <div class="card-body bg-light">
            <div class="row text-left">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="email" v-model="data.title" class="form-control" id="title">
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="row text-left">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" v-model="data.content" id="content" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row text-left">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="image">Image</label>
                     <img v-if="data.title" :src="('storage/images/'+data.photo)" style ="display: block; margin-left: auto; margin-right: auto; width: 50%;"  alt="image">
                    <input type="file" class="form-control-file" id="image" >
                  </div>
                </div>
            </div>
            <br>
            <article-tag-component :tags="data.tags" v-on:updateTags="updateTags"></article-tag-component>
            <br>
            <div class="row text-right">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-outline-dark" v-on:click="showTable">Back</button>
                        <button type="button" class="btn btn-outline-primary" v-on:click="save(data.id)">Save</button>
                        <button type="button" class="btn btn-outline-success" v-on:click="toPublish(data.id)">Publish</button>
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
                title:'',
                content:'',
                photo:'',
                tags:[],
                publish: false
            }
        },
        methods: {
            updateTags(tags) {
                this.tags = tags;
            },
            showTable(){
                this.$emit('showTable')
            },
            save(id){
                var imagefile = document.querySelector('#image');
                const formData = new FormData();
                formData.append("title", this.title);
                formData.append("content", this.content);
                formData.append("title", this.title);

                var arr = this.tags;
                for (var i = 0; i < arr.length; i++) {
                    formData.append('tags[]', arr[i]);
                }

                if(typeof  imagefile.files[0] !== "undefined")
                {
                    formData.append("photo", imagefile.files[0]);
                } 

                formData.append("publish", false);
                axios.post('api/article/'+id+'/update?_method=PATCH', formData)
                     .then((result)=>{
                       this.$emit('showTable')
                     }).catch((error)=>{
                       for (const key in error.response.data.errors) {
                           alert(error.response.data.errors[key][0])
                       }
                    });
            },
            toPublish(id){
                var imagefile = document.querySelector('#image');
                const formData = new FormData();
                formData.append("title", this.title);
                formData.append("content", this.content);
                formData.append("title", this.title);
                
                var arr = this.tags;
                for (var i = 0; i < arr.length; i++) {
                    formData.append('tags[]', arr[i]);
                }

                if(typeof  imagefile.files[0] !== "undefined")
                {
                    formData.append("photo", imagefile.files[0]);
                } 
                formData.append("publish", true);
                axios.post('api/article/'+id+'/update?_method=PATCH', formData)
                     .then((result)=>{
                       this.$emit('showTable')
                     }).catch((error)=>{
                       for (const key in error.response.data.errors) {
                           alert(error.response.data.errors[key][0])
                       }
                    });
            }
        },watch: {
            'data.title': function(val, preVal){
                this.title = val
            },
            'data.content': function(val, preVal){
                this.content = val
            }
        }
    }
</script> 