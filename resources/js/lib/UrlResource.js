import AbstractResource from './AbstractResource'
export default class UrlResource extends AbstractResource{
    constructor (axios) {
        super(axios)
        this.slug= 'urls'
    }
}
