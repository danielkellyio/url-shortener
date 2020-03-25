import {objectToQueryString} from '../helper'

export default class AbstractResource{
    constructor (axios) {
        this.axios = axios
        this.slug = ''
    }
    async index(){
        return this.axios.get(`/${this.slug}`)
    }
    async create(resource){
        return this.axios.post(`/${this.slug}`, resource)
    }
    async read(id){
        return this.axios.get(`/${this.slug}/${id}`, {
            '_method' : 'DELETE',
            id: id
        })
    }
    async update(id, resource){
        return this.axios.post(`/${this.slug}/${id}`, {
            '_method' : 'PUT',
            ...resource
        })
    }
    async destroy(id){
        return this.axios.post(`/${this.slug}/${id}`, { '_method' : 'DELETE' })
    }
    async count(params={}){
        const queryString = objectToQueryString(params);
        return this.axios.get(`/${this.slug}/count?${queryString}`)
    }
}
