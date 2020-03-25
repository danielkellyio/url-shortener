<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 align-items-center justify-content-between" style="display:flex">
                <div>Total: {{urlCount}}</div>
                <div class="mb-3">
                    <button @click="create()" class="btn btn-primary">New Short Url</button>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Shortened Url</th>
                        <th>Redirects To</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(url, index ) in urls">
                        <td>
                    <span v-if="editing === index" style="white-space:nowrap;">
                        {{appUrl}}/
                        <input
                            v-model="url.id"
                            style="width:150px;"
                            class="form-control form-control-sm d-inline-block"
                            @keyup.enter="update(index)"
                        >
                    </span>
                            <a v-else :href="`${appUrl}/${url.id}`" target="_blank">{{ `${appUrl}/${url.id}` }}</a>
                        </td>
                        <td>
                            <input
                                v-if="editing === index"
                                v-model="url.url"
                                class="form-control form-control-sm"
                                @keyup.enter="update(index)"
                            >
                            <a v-else :href="url.url" target="_blank">{{ url.url }}</a>
                        </td>
                        <td>
                    <span v-if="editing === index" >
                        <a href="#"  @click="update(index)">Save</a> |
                        <a href="#" @click="cancelEdit(index)">Cancel</a>
                    </span>

                            <a href="#" v-else @click.prevent="edit(index)">Edit</a>
                        </td>
                        <td>
                            <a href="#" @click.prevent="destroy(index)">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import UrlResource from '../lib/UrlResource'

    export default{
        data(){
            return {
                appUrl: window.appData.appUrl,
                urls: null,
                urlCount: null,
                editing: null,
                urlResource: null,
            }
        },
        methods:{
            edit(index){
                this.editing = index
                this.$nextTick(()=>{
                    this.$el.querySelector('input').focus()
                })
            },
            cancelEdit(index){
                if(!this.urls[index].originalId){
                    this.$delete(this.urls, index)
                }
                this.editing = null
            },
            async create(){
                this.urls.push({
                    id: '',
                    url: 'https://',
                    originalId: ''
                })
                this.edit(this.urls.length - 1)
            },
            async update(index){
                const url = this.urls[index]
                const id = url.originalId || url.id;
                this.$store.Alerts.clear()
                if( this.errorOnNoId(url) ) return
                if( this.errorOnDuplicateId(url) ) return

                try{
                    const res = await this.urlResource.update(id, url)
                    const newUrl = res.data
                    this.$set(this.urls, index, newUrl)
                    this.cancelEdit(index)
                    this.$store.Alerts.success('Url Saved!')
                }catch(error){
                    this.errorOnInvalids(error.response)
                }
            },
            async destroy(index){
                if(!this.urls[index].originalId){
                    this.cancelEdit(index);
                }else{
                    try{
                        const url = this.urls[index]
                        await this.urlResource.destroy(url.originalId)
                        this.$delete(this.urls, index)
                        this.$store.Alerts.success('Url Deleted!')
                    }catch(error){
                        this.$store.Alerts.danger(error)
                    }
                }
            },
            errorOnDuplicateId(url){
                const like = this.urls.filter(item => item.id === url.id )
                if(like.length > 1){
                    this.$store.Alerts.danger('Shortened url ending cannot already exist')
                    return true
                }
                return false
            },
            errorOnNoId(url){
                if(!url.id){
                    this.$store.Alerts.danger('Shortened url ending is required')
                    return true
                }
                return false
            },
            errorOnInvalids(res){
                const errors = res.data.errors
                Object.keys(errors).forEach((err)=>{
                    errors[err].forEach(message =>{
                        this.$store.Alerts.danger(message)
                    })
                })
            },
            async initCount(){
                const res = await this.urlResource.count()
                this.urlCount = res.data
            },
            async initUrls(){
                const res = await this.urlResource.index()
                this.urls = res.data
            }
        },
        async created(){
            this.urlResource = new UrlResource(window.axios)
            this.initCount()
            this.initUrls()

        },
        watch:{
            urls(){
                this.initCount()
            }
        }
    }
</script>
<style>
    .table td{
        vertical-align: middle;
    }
</style>
