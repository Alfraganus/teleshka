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
import { Pie } from "vue-chartjs";
export default {
  extends: Pie,
  data() {
    return {
      month: [
        { n: 1, name: "Yanvar" },
        { n: 2, name: "Fevral" },
        { n: 3, name: "Mart" },
        { n: 4, name: "Aprel" },
        { n: 5, name: "May" },
        { n: 6, name: "Iyun" },
        { n: 7, name: "Iyul" },
        { n: 8, name: "Avgust" },
        { n: 9, name: "Sentabr" },
        { n: 10, name: "Oktabr" },
        { n: 11, name: "Noyabr" },
        { n: 12, name: "Dekabr" }
      ],
      pprTypeLists: "",
      type: "pie",
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
    pprTypeList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/ppr/typelist")
        .then(response => {
          this.pprTypeLists = response.data.res;
          this.pprTypeLists.forEach(element => {
            this.data.labels.push(element.name);
            this.data.datasets[0].data.push(element.ppr_count);
          });
          this.renderChart(this.data, this.options);
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.pprTypeList();
  }
};
</script>
