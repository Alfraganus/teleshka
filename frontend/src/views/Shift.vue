<template>
  <div class="mx-4">
    <v-card-title class="elevation-1">
      Smenalar
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
        outlined
        color="#203d5b"
        dense
      ></v-text-field>
      <v-btn
        @click="newShift()"
        v-if="$user.role >= 1"
        color="success"
        class="ml-8"
        dark
        outlined
        small
        icon
      >
        <v-icon text>mdi-plus-thick</v-icon>
      </v-btn>
    </v-card-title>
    <v-divider></v-divider>
    <v-data-table
      :headers="headers"
      :items="shift"
      :search="search"
      :loading="Loading"
      loading-text="Loading... Please wait"
      class="elevation-3"
      :height="height - 200"
    >
      <template v-slot:item.id="{ item }">{{ shift.map(v => v.id).indexOf(item.id) + 1 }}</template>
      <template v-slot:item.icons="{ item }">
        <v-icon v-if="$user.role >= 1" @click="editShift(item)" color="primary">mdi-pencil</v-icon>
        <v-icon @click="deleteShift(item.id)" v-if="$user.role >= 2" color="red">mdi-delete</v-icon>
      </template>
    </v-data-table>

    <v-dialog v-model="saveShiftModal" persistent max-width="450px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ ShiftTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="form.name"
                  autofocus
                  hide-details="auto"
                  label="Smena nomi*"
                  color="#203d5b"
                  outlined
                  dense
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="justify-center">
          <v-btn color="green" dark @click="saveShift">Saqlash</v-btn>
          <v-btn color="red darken-1" dark @click="saveShiftModal = false">Yopish</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
  data() {
    return {
      shift: [],
      headers: [
        { text: "#", value: "id", width: 65 },
        {
          text: "Smena nomi",
          align: "start",
          value: "name"
        },
        { text: "", align: "right", value: "icons", sortable: false, width: 80 }
      ],
      search: "",
      Loading: true,
      name: "",
      addShiftModal: false,
      saveShiftModal: false,
      form: {},
      ShiftTitle: "",
      height: 600
    };
  },
  methods: {
    newShift() {
      this.saveShiftModal = true;
      this.ShiftTitle = "Smena qo'shish";
      this.form = {
        name: ""
      };
    },
    editShift(item) {
      this.saveShiftModal = true;
      this.ShiftTitle = "O'zgartirish";
      this.form = JSON.parse(JSON.stringify(item));
    },
    saveShift() {
      if (!this.form.id)
        this.$axios
          .post(this.$store.state.backend_url + "/api/shift/create", this.form)
          .then(response => {
            this.saveShiftModal = false;
            Swal.fire({
              position: "top-end",
              toast: true,
              icon: "success",
              title: "Saqlandi!!!",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
            this.Loading = true;
            this.getList();
            console.log(response.date);
          })
          .catch(function(error) {
            console.log(error);
          });
      else
        this.$axios
          .post(
            this.$store.state.backend_url + "/api/shift/update/" + this.form.id,
            this.form
          )
          .then(response => {
            this.saveShiftModal = false;
            Swal.fire({
              position: "top-end",
              toast: true,
              icon: "success",
              title: "Shift o'zgardi!!!",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
            this.Loading = true;
            this.getList();
            console.log(response.date);
          })
          .catch(function(error) {
            console.log(error);
          });
    },
    deleteShift(id) {
      Swal.fire({
        title: "O'chirish",
        text: "Siz ushbu Shiftni o'chirishga aminmisiz!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "O'chirish!",
        cancelButtonText: "Yopish"
      }).then(result => {
        if (result.value) {
          this.$axios
            .delete(this.$store.state.backend_url + "/api/shift/delete/" + id)
            .then(res => {
              this.Loading = true;
              this.getList();
              console.log(res.data);
            })
            .catch(function(error) {
              console.error(error);
            });
          Swal.fire({
            position: "top-end",
            toast: true,
            icon: "success",
            title: "O'chirildi",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
          });
        }
      });
    },
    getList() {
      setTimeout(
        () =>
          this.$axios
            .get(this.$store.state.backend_url + "/api/shift")
            .then(response => {
              this.shift = response.data;
              this.Loading = false;
            })
            .catch(function(error) {
              console.log(error);
            }),
        2000
      );
    }
  },
  mounted() {
    this.getList();
    this.height = document.getElementById("navbar").clientHeight;
  }
};
</script>