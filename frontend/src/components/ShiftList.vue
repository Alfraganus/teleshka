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
import { Doughnut } from "vue-chartjs";
export default {
  extends: Doughnut,
  data() {
    return {
      month: [
        { n: 1, name: "A smena" },
        { n: 2, name: "B smena" },
        { n: 3, name: "D smena" },
      ],
      ShiftLists: [],
      type: "Doughnut",
      data: {
        labels: [],
        datasets: [
          {
            label: "Smena davomida tamirlangan teleshkalar",
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
    ShiftList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/ppr/shiftlist")
        .then(response => {
          this.shiftLists = response.data;
          this.shiftLists.forEach(element => {
            this.data.labels.push(element.name);
            this.data.datasets[0].data.push(element.count);
          });
          this.renderChart(this.data, this.options);
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.ShiftList();
  }
};
</script>
