<template>
  <div class="mx-4">
    <v-card-title>
      Teleshkalar
      <v-btn
        class="ml-8"
        color="success"
        @click="newTelly()"
        v-if="$user.role >= 1"
      >Yangi teleshka qo'shish</v-btn>
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
      <template v-slot:item.id="{ item }">{{ tellies.map(v => v.id).indexOf(item.id) + 1 }}</template>
      <template v-slot:item.telly_type_id="{ item }">{{ item.telly_type.name}}</template>
      <template v-slot:item.icons="{ item }">
        <v-btn
          class="mr-4"
          color="primary"
          v-if="$user.role >= 1"
          @click="editTelly(item)"
          outlined
          small
          dark
        >
          <v-icon small>mdi-pencil</v-icon>
        </v-btn>

        <v-btn
          @click="addPpr(item.id)"
          class="mr-4"
          color="primary"
          v-if="$user.role >= 1"
          outlined
          small
          dark
        >
          <v-icon color="success" text small>mdi-cog</v-icon>
        </v-btn>

        <v-btn
          @click="deleteTelly(item.id)"
          color="primary"
          v-if="$user.role >= 2"
          outlined
          small
          dark
        >
          <v-icon color="red" text small>mdi-delete</v-icon>
        </v-btn>
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

    <v-dialog v-model="savePprModal" persistent max-width="450px">
      <v-card>
        <v-card-title>
          <span class="headline">{{ pprTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formppr.ppr_date"
                  autofocus
                  hide-details="auto"
                  label="Tamirlash vaqti"
                  color="#203d5b"
                  outlined
                  type="date"
                  dense
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  v-model="formppr.shift_id"
                  label="Shifts*"
                  hide-details="auto"
                  color="#203d5b"
                  outlined
                  :items="shift"
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
      telly_type: [],
      shift: [],
      search: "",
      Loading: true,
      telly_number: "",
      telly_type_id: "",
      telly_desc: "",
      saveTellyModal: false,
      savePprModal: false,
      form: {},
      formppr: {},
      tellyTitle: "",
      pprTitle: ""
    };
  },
  methods: {
    addPpr(id) {
      this.savePprModal = true;
      this.pprTitle = "Teleshka tamirlashni hisobga olish " + id;
      this.getShiftList();
    },
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
              timer: 1500
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
            width: "250px",
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
    getShiftList() {
      this.$axios
        .get(this.$store.state.backend_url + "/api/shift")
        .then(response => {
          this.shift = response.data;
          this.Loading = false;
        })
        .catch(function(error) {
          console.log(error);
        });
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
  }
};
</script>