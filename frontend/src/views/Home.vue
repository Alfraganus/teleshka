<template>
  <div>
    <v-card class="mx-4 pb-4">
      <v-card-title class="py-3 px-5">Bosh sahifa</v-card-title>
      <v-divider></v-divider>
      <v-row class="pa-8">
        <v-col class="pa-0" md="4" sm="6" xs="12">
          <a href="/users" style="text-decoration:none;">
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
          </a>
        </v-col>

        <v-col class="pa-0" md="4" sm="6" xs="12">
          <a href="/teleshka-list" style="text-decoration:none;">
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
          </a>
        </v-col>

        <v-col class="pa-0" md="4" sm="6" xs="12">
          <a href="/ppr" style="text-decoration:none;">
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
          </a>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="4">
          <PprList />
        </v-col>
        <v-col cols="4">
          <ShiftList />
        </v-col>
        <v-col cols="4">
          <PprTypeList />
        </v-col>
      </v-row>
    </v-card>
  </div>
</template>

<script>
import ShiftList from "@/components/ShiftList";
import PprList from "@/components/PprList";
import PprTypeList from "@/components/PprTypeList";
export default {
  components: {
    PprList,
    PprTypeList,
    ShiftList
  },
  data() {
    return {
      usersLength: "",
      tellysLength: "",
      pprsLength: ""
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
    }
  },
  mounted() {
    this.getUsersCount();
    this.getTellysCount();
    this.getPprCount();
  }
};
</script>
