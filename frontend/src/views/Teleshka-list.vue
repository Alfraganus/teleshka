<template>
  <div class="mx-4">
    <v-card-title class="elevation-1">
      Teleshkalar
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
        @click="newTelly()"
        v-if="$user.role >= 2"
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
    <v-divider :inset="inset"></v-divider>
    <v-data-table
      :headers="headers"
      :items="tellies"
      :search="search"
      :loading="Loading"
      loading-text="Loading... Please wait"
      class="elevation-2"
      :height="height - 200"
    >
      <template v-slot:item.id="{ item }">{{ tellies.map(v => v.id).indexOf(item.id) + 1 }}</template>
      <template v-slot:item.telly_type_id="{ item }">{{ item.telly_type.name}}</template>
      <template v-slot:item.icons="{ item }">
        <v-icon v-if="$user.role >= 1" @click="editTelly(item)" color="primary">mdi-pencil</v-icon>
        <v-icon v-if="$user.role >= 2" @click="deleteTelly(item.id)" color="red">mdi-delete</v-icon>
      </template>
    </v-data-table>

    <v-dialog v-model="saveTellyModal" persistent max-width="450px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ tellyTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="form.telly_number"
                  autofocus
                  hide-details="auto"
                  label="Telly №*"
                  color="#203d5b"
                  outlined
                  dense
                  type="number"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  v-model="form.telly_type_id"
                  label="Telly type*"
                  hide-details="auto"
                  color="#203d5b"
                  outlined
                  :items="telly_type"
                  item-text="name"
                  item-value="id"
                  dense
                ></v-select>
              </v-col>
              <v-col cols="12">
                <v-textarea
                  v-model="form.telly_desc"
                  hide-details="auto"
                  color="#203d5b"
                  outlined
                  dense
                  label="Description*"
                  persistent-hint
                  required
                ></v-textarea>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="justify-center">
          <v-btn color="green" dark @click="saveTelly">Save</v-btn>
          <v-btn color="red darken-1" dark @click="saveTellyModal = false">Close</v-btn>
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
      tellies: [],
      headers: [
        { text: "#", value: "id", width: 65 },
        {
          text: "Teleshka nomeri",
          align: "start",
          value: "telly_number"
        },
        { text: "Teleshka turi", value: "telly_type_id" },
        { text: "Tavsifnoma", value: "telly_desc" },
        {
          text: "",
          align: "right",
          value: "icons",
          sortable: false,
          width: 80
        }
      ],
      telly_type: [],
      search: "",
      Loading: true,
      telly_number: "",
      telly_type_id: "",
      telly_desc: "",
      saveTellyModal: false,
      form: {},
      tellyTitle: "",
      height: ""
    };
  },
  methods: {
    newTelly() {
      this.saveTellyModal = true;
      this.tellyTitle = "Yangi teleshka qo'shish";
      this.form = {
        telly_number: "",
        telly_type_id: "",
        telly_desc: ""
      };
    },
    editTelly(item) {
      this.saveTellyModal = true;
      this.tellyTitle = "O'zgartirish";
      this.form = JSON.parse(JSON.stringify(item));
    },
    saveTelly() {
      if (!this.form.id)
        this.$axios
          .post(
            this.$store.state.backend_url + "/api/tellies/create",
            this.form
          )
          .then(response => {
            this.saveTellyModal = false;
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: response.data,
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
            this.getList();
          })
          .catch(function(error) {
            console.log(error);
          });
      else
        this.$axios
          .post(
            this.$store.state.backend_url +
              "/api/tellies/update/" +
              this.form.id,
            this.form
          )
          .then(response => {
            this.saveTellyModal = false;
            Swal.fire({
              position: "top-end",
              toast: true,
              icon: "success",
              title: response.data,
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
            this.getList();
          })
          .catch(function(error) {
            console.log(error);
          });
    },
    deleteTelly(id) {
      Swal.fire({
        title: "O'chirish",
        text: "Siz ushbu teleshkani o'chirishga aminmisiz!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "O'chirish!",
        cancelButtonText: "Yopish"
      }).then(result => {
        if (result.value) {
          this.$axios
            .delete(this.$store.state.backend_url + "/api/tellies/delete/" + id)
            .then(res => {
              this.tellies = this.tellies.filter(v => v.id != id);
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
            .get(this.$store.state.backend_url + "/api/tellies")
            .then(response => {
              this.tellies = response.data;
              this.Loading = false;
            })
            .catch(function(error) {
              console.log(error);
            }),
        2000
      );
    },
    getTypeList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/telly-type")
        .then(resp => {
          this.telly_type = resp.data;
        })
        .catch(function(error) {
          console.error(error);
        });
    }
  },
  mounted() {
    this.getTypeList();
    this.getList();
    this.height = document.getElementById("navbar").clientHeight;
  }
};
</script>