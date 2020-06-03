<template>
  <div class="mx-4">
    <div class="px-10 py-4">
      <h1 class="title font-weight-medium">Teleshkalar</h1>
    </div>
    <div>
      <v-subheader class="primary py-8 px-10" dark>
        <v-btn color="success" dark>Yangi qo'shish</v-btn>
      </v-subheader>
    </div>
    <v-simple-table fixed-header height="auto">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left font-weight-bold">ID</th>
            <th class="text-left font-weight-bold">Fullname</th>
            <th class="text-left font-weight-bold">Email</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(telly, index) in tellies" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ telly.telly_name }}</td>
            <td>{{ telly.telly_type }}</td>
            <td>
              <v-btn class="mr-4" color="primary" outlined small dark>
                <v-icon small>mdi-pencil</v-icon>
              </v-btn>

              <v-btn @click="deleteUser(telly.id)" color="primary" outlined small dark>
                <v-icon color="red" text small>mdi-delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tellies: [],
    }
  },
  mounted() {
    this.$axios
      .get(this.$store.state.backend_url + "/api/tellies")
      .then(response => {
        this.tellies = response.data;
        // console.log(this.users);
      })
      .catch(function(error) {
        // handle error
        console.log(error);
      })
      .then(function() {
        // always executed
      });
  }
};
</script>