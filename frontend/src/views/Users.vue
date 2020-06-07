<template>
  <div class="mx-4">
    <v-card-title class="elevation-1">
      Foydalanuvchilar
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details="auto"
        outlined
        color="#203d5b"
        dense
      ></v-text-field>
      <v-btn
        @click="newUser()"
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
      :items="users"
      :search="search"
      :loading="Loading"
      loading-text="Loading... Please wait"
      class="elevation-3"
      :height="height - 200"
    >
      <template v-slot:item.id="{ item }">{{ users.map(v => v.id).indexOf(item.id) + 1 }}</template>
      <template
        v-slot:item.role="{ item }"
      >{{ userRoles.find( v => v.value == item.role) ? userRoles.find( v => v.value == item.role).text : '' }}</template>
      <template v-slot:item.icons="{ item }">
        <v-icon v-if="item.id != 1 && $user.role >= 1" @click="editUser(item)" color="primary">mdi-pencil</v-icon>
        <v-icon @click="deleteUser(item.id)" v-if="item.id != 1 && $user.role >= 2" color="red">mdi-delete</v-icon>
      </template>
    </v-data-table>
    <v-dialog v-model="saveUserModal" persistent max-width="450px">
      <v-card>
        <v-card-title>
          <span class="headline">Add user</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="form.tabel_number"
                  autofocus
                  hide-details="auto"
                  label="Tabel №*"
                  color="#203d5b"
                  outlined
                  type="number"
                  dense
                  required
                  :readonly="readonly"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-select
                  v-model="form.role"
                  label="Role*"
                  hide-details="auto"
                  color="#203d5b"
                  outlined
                  dense
                  :items="userRoles"
                ></v-select>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions class="justify-center">
          <v-btn color="green" dark @click="saveUser">Add</v-btn>
          <v-btn color="red darken-1" dark @click="saveUserModal = false">Close</v-btn>
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
      users: [],
      search: "",
      addUserModal: false,
      tabel_number: "",
      saveUserModal: false,
      form: {},
      Loading: true,
      readonly: false,
      newUserInfo: {},
      headers: [
        { text: "#", value: "id", width: 65 },
        {
          text: "F.I.O.",
          align: "start",
          value: "fullname"
        },
        { text: "Email", value: "email" },
        { text: "Login", value: "username" },
        { text: "Tabel nomeri", value: "tabel_number" },
        { text: "Role", value: "role" },
        {
          text: "",
          align: "right",
          value: "icons",
          sortable: false,
          width: 80
        }
      ],
      userRoles: [
        { text: "User", value: "0" },
        { text: "Admin", value: "1" },
        { text: "Administrator", value: "2" }
      ],
      height: 600
    };
  },
  methods: {
    newUser() {
      this.saveUserModal = true;
      this.readonly = false;
      this.form = {
        tabel_number: "",
        role: ""
      };
    },
    editUser(item) {
      this.saveUserModal = true;
      this.readonly = true;
      this.form = JSON.parse(JSON.stringify(item));
    },
    saveUser() {
      if (!this.form.id) {
        this.$axios
          .get(
            "http://wb.uzautomotors.com/api/get-all-employees/" +
              this.form.tabel_number
          )
          .then(res => {
            this.newUserInfo = res.data[0];
            this.$axios
              .post(this.$store.state.backend_url + "/api/users/create", {
                fullname:
                  this.newUserInfo.firstname_uz_latin +
                  " " +
                  this.newUserInfo.lastname_uz_latin +
                  " " +
                  this.newUserInfo.middlename_uz_latin,
                tabel_number: this.form.tabel_number,
                username:
                  this.newUserInfo.firstname_uz_latin
                    .substr(0, 1)
                    .toLowerCase() +
                  this.newUserInfo.lastname_uz_latin
                    .substr(0, 1)
                    .toLowerCase() +
                  this.form.tabel_number,
                role: this.form.role,
                email:
                  this.newUserInfo.firstname_uz_latin
                    .substr(0, 1)
                    .toLowerCase() +
                  this.newUserInfo.lastname_uz_latin
                    .substr(0, 1)
                    .toLowerCase() +
                  this.form.tabel_number +
                  "@uzautomotors.com"
              })
              .then(response => {
                this.saveUserModal = false;
                Swal.fire({
                  position: "top-end",
                  toast: true,
                  icon: "success",
                  title: "Saqlandi!!!",
                  showConfirmButton: false,
                  timer: 1500,
                  timerProgressBar: true
                });
                this.users.push(response.data);
              })
              .catch(function(error) {
                console.error(error);
              });
          })
          .catch(function(error) {
            console.error(error);
            //this.saveUserModal = false;
            Swal.fire({
              title: "Bunday tabel mavjud emas..!",
              icon: "error",
              confirmButtonColor: "#d33"
            });
          });
      } else
        this.$axios
          .post(
            this.$store.state.backend_url + "/api/users/update/" + this.form.id,
            this.form
          )
          .then(response => {
            this.saveUserModal = false;
            this.users = this.users.map(v => {
              if (v.id == response.data.id) v = response.data;
              return v;
            });
            Swal.fire({
              position: "top-end",
              toast: true,
              icon: "success",
              title: "O'zgartirildi!!!",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
          })
          .catch(function(error) {
            console.error(error);
          });
    },
    deleteUser(id) {
      Swal.fire({
        title: "O'chirish",
        text: "Siz ushbu foydalanuvchini o'chirishga aminmisiz!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "O'chirish!",
        cancelButtonText: "Yopish"
      }).then(result => {
        if (result.value) {
          this.$axios
            .delete(this.$store.state.backend_url + "/api/users/delete/" + id)
            .then(res => {
              this.users = this.users.filter(v => v.id != id);
              console.error(res.data);
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
            .get(this.$store.state.backend_url + "/api/users")
            .then(response => {
              this.users = response.data;
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

// Toxir aka: 8110, Qodir aka: 9592
</script>