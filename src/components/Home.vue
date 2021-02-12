<template>
  <div class="vue-page-container" id="home">
    <h1>{{ msg }}</h1>
    
   <h3 align="center">Vue Fetch data from php mysql </h3>
    <br />
   <div class="panel panel-default">
    <div class="panel-heading">
     <div class="row">
      <div class="col-md-6">
      </div>
         

  <div v-if="myModel">
    <transition name="model">
    
     <div class="modal-mask">
      <div class="modal-wrapper">
       <div class="modal-dialog">
      
        <div class="modal-content">
         
         <div class="modal-header">    
         
          <h4  class="modal-title"  >{{ form_title }}</h4>
         <button type="button"  class="close col-md-3"  @click="closeModel"><span aria-hidden="true">&times;</span></button>        
          
         </div>
         <div class="modal-body">
         <div class="form-group">
           <label>Enter First Name</label>
           <input type="text" class="form-control" id="f_name" v-model="fname" />
          </div>
          <div class="form-group">
           <label>Enter Last Name</label>
           <input type="text" class="form-control" v-model="lname" />
          </div>
           <div class="form-group">
           <label>Enter Gender</label>
           <input type="text" class="form-control" v-model="gender" />
          </div>
           <div class="form-group">
           <label>Enter Username</label>
           <input type="text" class="form-control" v-model="username" />
          </div>
           <div class="form-group">
           <label>Enter Password</label>
           <input type="password" class="form-control" v-model="password" />
          </div>
          <br />
          <div align="center">
           <input type="hidden" v-model="hiddenId" />
           <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="submit_user_data()" />
          </div>


         </div>

        </div>
       </div>
      </div>
     </div>
    </transition>
   </div>


     </div>
    </div>

 
    <br>
    <div class="panel-body">
     <div class="table-responsive table-container">
       <div class="col-md-12" align="right">
        <input type="button" class="btn btn-success btn-xs" @click="openModel" value="+ Add New Member" />
        </div>
        <br>
      <table class="table table-bordered table-striped">
       <tr>
        <th>First Name</th>
        <th>Last Name</th>
         <th>Gender</th>
        <th>Username</th>
        <th>Edit</th>
        <th>Delete</th>

         </tr>
        <tr v-for="item in allData" v-bind:key="item.id">
          <td>{{ item.fname }}</td>
          <td>{{ item.lname }}</td>
          <td>{{ item.gender }}</td>
            <td>{{ item.username }}</td>
            <td><input type="button" class="btn btn-primary btn-xs" value='Edit' @click="Edit_fetch(item.id)" /></td>
             <td><input type="button" class="btn btn-danger btn-xs" value='Delete' @click="Delete_data(item.id)" /></td>
        
            </tr>
            </table>
          </div>
          </div>
        </div>
   

  </div>
</template>

<script>

import axios from 'axios'

 export default  {
  name: 'Home',
  props: {
    msg: String
  
  },
 mounted(){
  
   axios.get('http://localhost/php_backend/backend_api.php')
     // axios.get('http://aljaydesign-al.000webhostapp.com/sample_api/api.php')
  
  .then((res)=>{

    this.allData = res.data
     console.log(res.data)
  })

 },
 data(){
  return {allData:'',  
          myModel:false,
          actionButton:'Insert',
          form_title:'Add new member',
          hiddenId:'',
          fname:'',
          lname:'',
          gender:'',
          username:'',
          password:''
         
  
  }
  
}, 

 methods:{
  
   allrecords: function(){
     axios.get('http://localhost/php_backend/backend_api.php')
     // axios.get('http://aljaydesign-al.000webhostapp.com/sample_api/api.php')
  
   .then((res)=>{

    this.allData = res.data
 
   })

   },

   openModel:function(){
   
    this.fname = "",
    this.lname = "",
    this.gender = "",
    this.username = "",
    this.password = "",
    this.hiddenId = "",
    this.actionButton = 'Insert';
  this.form_title = 'Add new member';
   this.myModel = true;
  },

   closeModel:function(){
   
   this.myModel = false;
    this.allrecords();
   
  },

   submit_user_data: function(){
  
   if(this.fname != '' && this.lname != '' && this.gender != '' && this.username !='' && this.password !='')
   {
  if(this.actionButton == 'Insert')
    {
     axios.post('http://localhost/php_backend/action.php', {
      
      action:'insert',
      fname: this.fname, 
      lname: this.lname,
      gender: this.gender, 
      username: this.username, 
      password: this.password,
         

     }).then(function(response){
        
         alert(response.data.message);    
          
             this.allrecords();         
     });

              this.fname = "",
              this.lname = "",
              this.gender = "",
              this.username = "",
              this.password = "",
              this.allrecords();  
    }
    //end insert
if(this.actionButton == 'update')
    {
     axios.post('http://localhost/php_backend/action.php', {
      action:'update',
      fname: this.fname, 
      lname: this.lname,
      gender: this.gender, 
      username: this.username, 
      password: this.password,
      hiddenId : this.hiddenId
     }).then(function(response){ //this is a function for response old 
     
      alert(response.data.message);
     });
    }
}
},

    Delete_data:function(id){
   if(confirm("Are you sure you want to remove this data?"))
   {
    axios.post('http://localhost/php_backend/action.php', {
     action:'delete_data',
     id:id
    }).then((response)=>{// this is a arrow function for response es6
          this.allrecords(); 
     alert(response.data.message);
 
    });
   }
  },
 
Edit_fetch:function(id){
   axios.post('http://localhost/php_backend/action.php', {
    action:'edit',
    id:id
 
   })
  // 
   .then((response)=>{
      console.log(response.data);
      this.fname = response.data.fname;
      this.lname = response.data.lname;
      this.gender = response.data.gender;
      this.username = response.data.username;
      this.password = response.data.password;
      this.hiddenId = response.data.id;

  
   });
    
  
     this.form_title = 'Edit member';
      this.actionButton = 'update';
      this.myModel = true;


  },


  
    
  
  

  
},

};

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.form-add{
  border:1px solid green;
  margin:20px auto;
  padding:20px;
}
.table{max-width:100%;}
.table-container{
  height:auto;
  width:700px;
  overflow:auto;
  margin:20px auto;
  padding:20px;
  box-shadow:1px 1px 10px 2px #eee;
}
th{
  background:#1d1d1d;
  color:#ffffff;

}

 .modal-mask {
     position: fixed;
     z-index: 9998;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0, 0, 0, .5);
     display: table;
     transition: opacity .3s ease;
   }

   .modal-wrapper {
     display: table-cell;
     vertical-align: middle;
   }
   .close{
     padding:15px;
     
     color:red;
     
     text-align:right;
   }
</style>
