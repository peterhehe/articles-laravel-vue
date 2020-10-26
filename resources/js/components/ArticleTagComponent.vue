<template>
    <div class="tags-input-container">
        <div class="tag" v-for="(tag, index) in tags" :key="'tag'+index">
            <span>{{tag}}</span>
            <span @click="removeTag(index)"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-dash-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
            </svg></span>
        </div>
        <br>
        <br>
        <input v-model="tagValue" @keyup.enter="addTag" placeholder="Tags"/>
    </div>
</template>

<script>
 export default {
        props: ['tags'],
        data() {
            return {
               tagValue:''
            }
        },
        methods: {
            addTag() {
                if(!this.tagValue == '') {
                    this.tags.push(this.tagValue);
                }
                this.tagValue = '';
                this.$emit('updateTags', this.tags)
            },
            removeTag(index) {
                this.tags.splice(index, 1);
                this.tagValue = '';
                this.$emit('updateTags', this.tags)
            }
        }
    }
</script>

<style lang="scss">
    .tags-input-containter {
        width: 100%;
        max-width: 600px;
        padding: 10px;
        background-color: rgba($color: #fff, $alpha: .7);

        input {
            width: 100%;
            padding: 0;
            margin: 0;
            border: 0;
            outline: none;
            background-color: transparent;
            font-size: 1rem;
        }
    }

    .tag {
        float: left;
        padding: 3px 5px;
        display:flex;
        justify-content: center;
        cursor: pointer;

        &:hover {
            background-color: #81d8d0   ;
            border-radius: 5px;
        }
        
        span:first-child {
            margin-right: 8px;
        }

        svg {
            color: #0e2f44;
        }
    }

</style>