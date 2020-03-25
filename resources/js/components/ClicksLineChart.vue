<template>
    <div>
        <h3>All Clicks</h3>
        <p>Last
            <input class="form-control d-inline" type="number" v-model="numOfDays" min="2" :max="numOfDaysMax" style="width:60px;">
            Days (Total: {{ clicksCount }})</p>
        <canvas width="100%"></canvas>
    </div>
</template>
<script>
    import Chart from 'chart.js'
    import ClickResource from '../lib/ClickResource'
    export default{
        data(){
            return {
                numOfDays: 7,
                numOfDaysMax: 30,
                clicks: {},
                clicksCount: null,
                clickResource: null,
                loading: false,
            }
        },
        props:{
          days: {}
        },
        methods:{
            async initChart(){
                this.loading = true
                await this.countForEachDay()
                let ctx = this.$el.querySelector('canvas');
                new Chart(ctx, {
                    aspectRatio: 1,
                    type: 'line',
                    data: {
                        labels: Object.keys(this.clicks).reverse(),
                        datasets: [{
                            label: '# of Clicks',
                            data: Object.values(this.clicks).reverse(),
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
                this.loading = false
            },
            getTimestamp(daysAgo){
                const today = new Date()
                const previousDay = new Date(today)
                previousDay.setDate(previousDay.getDate() - daysAgo)
                return previousDay.toDateString()
            },
            async countForEachDay(){
                if(this.numOfDays > this.numOfDaysMax){
                    this.numOfDays = this.numOfDaysMax;
                }
                if(this.numOfDays){
                    this.clicks = {}
                    let days = [];
                    for (var i = 0; i < this.numOfDays; i++) {
                        days[i] = i;
                    }
                    const res = await this.clickResource.count({days: days})
                    res.data.forEach((value, i)=>{
                        this.clicks[this.getTimestamp(i)] = value
                    })
                }
            },
            async refresh(){
                const res = await this.clickResource.count({days: this.numOfDays, forLastXDays: true})
                this.clicksCount = res.data
                this.initChart()
            }
        },
        async mounted () {
            this.clickResource = new ClickResource(window.axios)
            const res = await this.clickResource.count({days: this.numOfDays, forLastXDays: true})
            this.clicksCount = res.data
            this.initChart()
        },
        watch:{
            async numOfDays(){
                if(!this.loading) this.refresh()
            }
        }
    }
</script>
