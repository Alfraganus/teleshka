<template>
  <div>
    <v-card class="mx-4">
      <div>
        <canvas ref="canvas"></canvas>
      </div>      
    </v-card>
  </div>
</template>

<script>
import { Bar } from "vue-chartjs";
export default {
  extends: Bar,
  data() {
    return {
      month: [
        {n: 1, name: "Yanvar"},
        {n: 2, name: "Fevral"},
        {n: 3, name: "Mart"},
        {n: 4, name: "Aprel"},
        {n: 5, name: "May"},
        {n: 6, name: "Iyun"},
        {n: 7, name: "Iyul"},
        {n: 8, name: "Avgust"},
        {n: 9, name: "Sentabr"},
        {n: 10, name: "Oktabr"},
        {n: 11, name: "Noyabr"},
        {n: 12, name: "Dekabr"},
      ],
      pprLists: "",
      type: 'bar',
      data: {
        labels: [],
        datasets: [
          {
            label: "Tamirlangan teleshkalar",
            data: [],
            backgroundColor: [
              "rgba(255, 99, 132, 0.8)",
              "rgba(54, 162, 235, 0.8)",
              "rgba(255, 206, 86, 0.8)",
              "rgba(75, 192, 192, 0.8)",
              "rgba(153, 102, 255, 0.8)",
              "rgba(255, 159, 64, 0.8)"
            ],
            borderColor: [
              "rgba(255, 99, 132, 1)",
              "rgba(54, 162, 235, 1)",
              "rgba(255, 206, 86, 1)",
              "rgba(75, 192, 192, 1)",
              "rgba(153, 102, 255, 1)",
              "rgba(255, 159, 64, 1)"
            ],
            borderWidth: 1
          }
        ]
      },
      options: {
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: true
              }
            }
          ]
        }
      }
    };
  },
  methods: {
    pprList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/ppr/list")
        .then(response => {
          this.pprLists = response.data;
          this.pprLists.forEach(element => {
            this.data.labels.push(this.month.find(v => v.n == element.month).name);
            this.data.datasets[0].data.push(element.ppr_count);
          });
          this.renderChart(this.data, this.options);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
  },
  mounted() {
    this.pprList();
  }
};
</script>
