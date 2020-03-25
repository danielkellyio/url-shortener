import AbstractResource from './AbstractResource'

export default class ClickResource extends AbstractResource{
    constructor (axios) {
        super(axios)
        this.slug= 'clicks'
    }

    // Click resource does not support these CRUD operations
    create(resource){ return false }
    read(id){ return false }
    update(id, resource){ return false }
    destroy(id){ return false }
}
