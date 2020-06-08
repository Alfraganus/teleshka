<template>
  <div>
    <v-card class="mx-4">
      <v-card-title class="py-3 px-5">Bosh sahifa</v-card-title>
      <v-divider></v-divider>
      <v-row class="pa-8">
        <v-col class="pa-0" md="4" sm="6" xs="12">
          <v-card class="mr-2">
            <v-list-item class="px-3 mb-4" three-line>
              <!-- <v-list-item-avatar tile size="80" color="grey"> -->
              <v-btn class="py-8" color="cyan" dark>
                <v-icon large dark>mdi-account-group-outline</v-icon>
              </v-btn>
              <!-- </v-list-item-avatar> -->
              <v-list-item-content class="align-self-center py-1 px-3">
                <v-list-item-subtitle class="subtitle-1 font-weight-regular">Foydalanuvchilar</v-list-item-subtitle>
                <v-list-item-title class="subtitle-1 font-weight-medium">{{ usersLength }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-card>
        </v-col>

        <v-col class="pa-0" md="4" sm="6" xs="12">
          <v-card class="mx-2">
            <v-list-item class="px-3 mb-4" three-line>
              <!-- <v-list-item-avatar tile size="80" color="grey"> -->
              <v-btn class="py-8" color="cyan" dark>
                <v-icon large dark>mdi-caravan</v-icon>
              </v-btn>
              <!-- </v-list-item-avatar> -->
              <v-list-item-content class="align-self-center py-1 px-3">
                <v-list-item-subtitle class="subtitle-1 font-weight-regular">Teleshkalar</v-list-item-subtitle>
                <v-list-item-title class="subtitle-1 font-weight-medium">{{ tellysLength }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-card>
        </v-col>

        <v-col class="pa-0" md="4" sm="6" xs="12">
          <v-card class="ml-2">
            <v-list-item class="px-3 mb-4" three-line>
              <!-- <v-list-item-avatar tile size="80" color="grey"> -->
              <v-btn class="py-8" color="cyan" dark>
                <v-icon large dark>mdi-car-cog</v-icon>
              </v-btn>
              <!-- </v-list-item-avatar> -->
              <v-list-item-content class="align-self-center py-1 px-3">
                <v-list-item-subtitle class="subtitle-1 font-weight-regular">Tamirlangan teleshkalar</v-list-item-subtitle>
                <v-list-item-title class="subtitle-1 font-weight-medium">{{ pprsLength }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-card>
        </v-col>
      </v-row>
      <div style="max-width:700px; margin:0 auto;">
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
      usersLength: "",
      tellysLength: "",
      pprsLength: "",
      pprLists: "",
      pprTypeLists: "",
      data: {
        labels: [],
        datasets: [
          {
            label: "Tamirlangan teleshkalar",
            data: [],
            backgroundColor: [
              "rgba(255, 99, 132, 0.5)",
              "rgba(54, 162, 235, 0.5)",
              "rgba(255, 206, 86, 0.5)",
              "rgba(75, 192, 192, 0.5)",
              "rgba(153, 102, 255, 0.5)",
              "rgba(255, 159, 64, 0.5)"
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
    getUsersCount() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/users")
        .then(response => {
          this.usersLength = response.data.length;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getTellysCount() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/tellies")
        .then(response => {
          this.tellysLength = response.data.length;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getPprCount() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/ppr")
        .then(response => {
          this.pprsLength = response.data.length;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    pprList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/ppr/list")
        .then(response => {
          this.pprLists = response.data;
          this.pprLists.forEach(element => {
            this.data.labels.push(this.month.find(v => v.n == element.month).name);
            this.data.datasets[0].data.push(element.count);
          });
          this.renderChart(this.data, this.options);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    pprTypeList(){
      this.$axios
        .get(this.$store.state.backend_url + "/api/ppr/typelist")
        .then(response => {
          // this.pprTypeLists = response.data;
          console.log(response);
          // this.pprTypeLists.forEach(element => {
          //   this.data.labels.push(this.month.find(v => v.n == element.month).name);
          //   this.data.datasets[0].data.push(element.count);
          // });
          // this.renderChart(this.data, this.options);
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.getUsersCount();
    this.getTellysCount();
    this.getPprCount();
    // this.renderChart(this.data, this.options);
    this.pprList();
    this.pprTypeList();
  }
};
</script>
