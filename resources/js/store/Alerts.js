import AbstractStore from './AbstractStore'

class Alerts extends AbstractStore{
    constructor () {
        super();
    }

    danger(message, options = { type: 'danger', timeout: 2000 }){
        this.add({
            ...options,
            message: message,
        })
    }

    success(message, options = { type: 'success', timeout: 2000 }){
        this.add({
            ...options,
            message: message,
        })
    }

    warning(message, options = { type: 'warning', timeout: 2000 }){
        this.add({
            ...options,
            message: message,
        })
    }

    info(message, options = { type: 'info', timeout: 2000 }){
        this.add({
            ...options,
            message: message,
        })
    }

    add(alert){
        alert.id = Date.now()
        this._state.push(alert)
        if(alert.timeout){
            setTimeout(()=>{
                this.remove(alert.id)
            }, alert.timeout)
        }
    }

    remove(id){
        this._state = this._state.filter(notif => notif.id !== id)
    }

    clear(){
        this._state = []
    }
}

export default new Alerts()
