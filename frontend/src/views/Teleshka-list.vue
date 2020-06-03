<template>
  <div class="mx-4">
    <v-card-title>
      Teleshkalar
      <v-btn class="ml-8" color="success" @click="newTelly()">Add user</v-btn>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-data-table
      :headers="headers"
      :items="tellies"
      :search="search"
      :loading="Loading"
      loading-text="Loading... Please wait"
    >
      <template
        v-slot:item.role="{ item }"
      >{{ roles.find( v => v.value == item.role) ? roles.find( v => v.value == item.role).text : '' }}</template>
      <template v-slot:item.icons="{ item }">
        <v-btn class="mr-4" color="primary" @click="editUser(item)" outlined small dark>
          <v-icon small>mdi-pencil</v-icon>
        </v-btn>

        <v-btn @click="deleteUser(item.id)" color="primary" outlined small dark>
          <v-icon color="red" text small>mdi-delete</v-icon>
        </v-btn>
      </template>
    </v-data-table>
  </div>
</template>

<script>

//import Swal from "sweetalert2";

export default {
  data() {
    return {
      tellies: [],
      headers: [
        { text: "ID", value: "id" },
        {
          text: "Telly №",
          align: "start",
          value: "telly_number"
        },
        { text: "Telly type", value: "telly_type_id" },
        { text: "Description", value: "telly_desc" },
        { text: "", align: "right", value: "icons", sortable: false }
      ],
      search: "",
      Loading: true,
      telly_number: "",
      telly_desc: "",
      addTellyModal: false,
      saveTellyModal: false,
      form: {},
    }
  },
  methods: {
    getList() {
      setTimeout(
        () =>
          this.$axios
            .get(this.$store.state.backend_url + "/api/tellies")
            .then(response => {
              this.tellies = response.data;
              this.Loading = false;
            })
            .catch(function(error) {
              console.log(error);
            }),
          this.tellies = [
            {
              id: 1, 
              telly_number: 1345, 
              telly_type_id: 2, 
              telly_desc: "katrej yuklash uchun"
            }
          ],
          this.Loading = false,
        2000
      );
    }
  },
  mounted() {
    this.getList();
  },
};
</script>