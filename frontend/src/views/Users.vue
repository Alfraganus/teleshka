<template>
  <div class="mx-4">
    <v-card-title>
      Foydalanuvchilar
      <v-btn class="ml-8" color="success" v-if="$user.role >= 2" @click="newUser()">Add user</v-btn>
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
      :items="users"
      :search="search"
      :loading="Loading"
      loading-text="Loading... Please wait"
    >
      <template v-slot:item.id="{ item }">{{ users.map(v => v.id).indexOf(item.id) + 1 }}</template>
      <template
        v-slot:item.role="{ item }"
      >{{ userRoles.find( v => v.value == item.role) ? userRoles.find( v => v.value == item.role).text : '' }}</template>
      <template v-slot:item.icons="{ item }">
        <v-btn
          class="mr-4"
          color="primary"
          v-if="item.id != 1 && $user.role >= 1"
          @click="editUser(item)"
          outlined
          small
          dark
        >
          <v-icon small>mdi-pencil</v-icon>
        </v-btn>

        <v-btn
          @click="deleteUser(item.id)"
          v-if="item.id != 1 && $user.role >= 2"
          color="primary"
          outlined
          small
          dark
        >
          <v-icon color="red" text small>mdi-delete</v-icon>
        </v-btn>
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
                  v-model="form.tabel_num"
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
                <v-text-field
                  v-model="form.email"
                  hide-details="auto"
                  color="#203d5b"
                  outlined
                  dense
                  label="Email*"
                  :rules="[rules.required, rules.email]"
                  persistent-hint
                  required
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
      fullName: "",
      userName: "",
      tabel_num: "",
      saveUserModal: false,
      form: {},
      Loading: true,
      email: "",
      readonly: false,
      newUserInfo: {},
      creatUser: {},
      headers: [
        { text: "ID", value: "id" },
        {
          text: "Fullname",
          align: "start",
          value: "fullname"
        },
        { text: "Email", value: "email" },
        { text: "Username", value: "username" },
        { text: "Tabel #", value: "tabel_number" },
        { text: "Role", value: "role" },
        { text: "", value: "icons", sortable: false }
      ],
      rules: {
        required: value => !!value || "Required.",
        counter: value => value.length <= 40 || "Max 40 characters",
        email: value => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(value) || "Invalid e-mail.";
        }
      },
      userRoles: [
        {
          text: "User",
          value: "0"
        },
        {
          text: "Admin",
          value: "1"
        },
        {
          text: "Administrator",
          value: "2"
        }
      ]
    };
  },
  methods: {
    newUser() {
      this.saveUserModal = true;
      this.form = {
        tabel_num: "",
        role: "",
        email: ""
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
              this.form.tabel_num
          )
          .then(res => {
            this.newUserInfo = res.data;
            this.creatUser = {
              email: this.form.email,
              fullname:
                this.newUserInfo.firstname_uz_latin +
                " " +
                this.newUserInfo.lastname_uz_latin +
                " " +
                this.newUserInfo.middlename_uz_latin,
              tabel_number: this.form.tabel_num.substr(0,1),
              username: this.form.tabel_num,
              role: this.form.role
            };
            // this.$axios
            //   .post(
            //     this.$store.state.backend_url + "/api/users/create",
            //     (email = this.form.email),
            //     (fullname =
            //       this.newUserInfo.firstname_uz_latin +
            //       " " +
            //       this.newUserInfo.lastname_uz_latin +
            //       " " +
            //       this.newUserInfo.middlename_uz_latin),
            //     (tabel_number = this.form.tabel_num),
            //     (username = this.form.tabel_num),
            //     (role = this.form.role)
            //   )
            //   .then(response => {
            //     this.saveUserModal = false;
            //     this.users.push(response.data);
            //   })
            //   .catch(function(error) {
            //     console.error(error);
            //   });
            console.log(this.creatUser);
          })
          .catch(function(error) {
            console.error(error);
          });
      } else console.log(this.tabel_num);
      // this.$axios.get("http://wb.uzautomotors.com/api/get-all-employees/" + this.tabel_num)
      //   .then(newUser => {
      //     console.error(newUser.data);
      //   })
      //   .catch(function(error) {
      //     console.error(error)
      //   })
      // this.$axios
      //   .post(
      //     this.$store.state.backend_url + "/api/users/update/" + this.form.id,
      //     this.form
      //   )
      //   .then(response => {
      //     this.saveUserModal = false;
      //     this.users = this.users.map(v => {
      //       if (v.id == response.data.id) v = response.data;
      //       return v;
      //     });
      //   })
      //   .catch(function(error) {
      //     console.error(error);
      //   });
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
          Swal.fire(
            "O'chirildi!",
            "Ushbu foydalanuvchi o'chirildi.",
            "success"
          );
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
    this.$axios
      .get("http://wb.uzautomotors.com/api/get-all-employees/8110")
      .then(response => {
        console.log(response);
      })
      .catch(function(error) {
        console.log(error);
      });
  }
};

// Toxir aka: 8110, Qodir aka: 9592
</script>