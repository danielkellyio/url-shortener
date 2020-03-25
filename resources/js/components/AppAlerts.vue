<template>
    <ul id="app-alerts">
        <li v-for="alert in alerts" :class="`alert alert-${alert.type}`" >
            {{alert.message}}
        </li>
    </ul>
</template>

<script>
    export default{
        name: 'AppAlerts',
        computed:{
            alerts(){
                return this.$store.Alerts.state
            }
        }
    }
</script>

<style scoped lang="scss">
    #app-alerts{
        list-style: none;
        position:absolute;
        bottom:10px;
        right:10px;
    }
</style>
