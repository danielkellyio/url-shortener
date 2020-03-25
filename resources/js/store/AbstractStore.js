export default class AbstractStore{
    constructor(){
        this._state = []
    }
    get state(){
        return this._state
    }
}
