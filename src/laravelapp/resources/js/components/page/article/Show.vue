<template>
<div>

   <div class="comment-error"> </div>
<div class="show-main">

  <div class="show-box">
    <div class="show-user-data">

    <router-link 
    :to="{name: 'userpage',
    query: {userId: postUser.id}}"
    v-if="postUser.id !== auth.id"
    >
       <img :src="postUser.profile_image"          class="show-user-image">

    </router-link>

    <a @click.stop.prevent="goUrlPage('/mypage/show')"
      v-if="postUser.id === auth.id"
    >
       <img class="top-article-myimage"
       :src="postUser.profile_image">
    </a>

      <li class="show-article-user">
          {{ postUser.name }}
       </li>
        <li class="show-created-at">
          {{ article.created_at }}
        </li>
    </div>     
        <div class="show-title-box">
          <li class="show-title">{{ article.title }}</li>
        </div>

      <template v-for="(tag,index) in tag">
        <div class="show-tag">
            {{ tag.name }}
        </div>
      </template>

        <div class="show-like-box">
    
              <!-- Review.phpに作ったisLikedByメソッドをここで使用 -->
              <article-like 
              :user_id ="auth.id"
              :article_id="article.id"
              >
              </article-like>
       
           <!-- 記事を書いたユーザーであれば公開、非公開を切り替えるリンクを表示 -->
        
            <form 
            action="/article/status" 
            class="show-form-status" method="get" 
            v-if=" postUser.id === auth.id "
            > 
             
                <input type="hidden" name="_token" :value="csrf" />
                <input 
                  :value="article.id" 
                  type="hidden" 
                  class="show-status" 
                  name="article_id"
                >
                <button 
                  type="submit" 
                  class="show-status-btn"
                  v-if="article.status === 0 "
                >
                  公開する
                </button>
            
                <input 
                :value="article.id" 
                type="hidden" 
                class="show-status" 
                name="article_id"
                >
                <button 
                type="submit" 
                class="show-status-btn"
                v-if="article.status === 1 "
                >
                  非公開にする
                </button>
             
            </form>
     

       <!-- 記事を書いたユーザーであれば編集と削除のリンクを表示 -->
    
        <div 
        class="show-linkbox"
        v-if=" postUser.id === auth.id "
        >

           <router-link 
           :to="{name: 'article-edit',
            query: {articleId: article.id}}"
            v-if="auth.length !== 0"
            class="show-link-edit"
           >
            編集
            </router-link>

          <form 
            action="/article/destroy"
            method="post" 
            class="destroy-form"
            >
            <input type="hidden" name="_token" :value="csrf" />
            <input 
            type="hidden" 
            name="article_id"
            :value="article.id"
            >
            <input 
            type='submit' 
            value="削除" 
            class="show-link-delete"
            onclick="return confirm('削除しますか？');"
            >
          </form>
        </div>
      
        </div>
        <!-- ここまでlike-box -->
      </div>
      <!-- ここまでshowーbox -->

      <div class="show-body-box">
        <li class="show-body" v-html="article_parse_body"></li>
      </div>

  </div>
  <!-- ここまでshow-main -->

  <!-- ここからコメント -->
  <h2 style=
      "background-color: #eee; 
       color: #333;
       width: 100%;
       height: 40px;
       margin-top: 10px;
       text-align: left;
       font-size: 2.5rem;
       margin-left: 5%;
       ">
       コメント一覧
  </h2>

  <div class="show-border"></div>
  <div class="show-comment-container">
  
<template v-for="(comment,index) in comments ">

 <div class="show-comment-box">

 
      <li class=comment-user>

         <router-link 
          :to="{name: 'userpage',
          query: {userId: comment.user.id}}"
          v-if="comment.user.id !== auth.id"
         >
            <img :src="comment.user.profile_image"          class="show-user-image">

      </router-link>

    <a @click.stop.prevent="goUrlPage('/mypage/show')"
      v-if="comment.user.id === auth.id">

       <img class="top-article-myimage"
       :src="comment.user.profile_image">

    </a>
        
        <div class="comment-user-name">
          {{ comment.user.name }}
        </div>
     
        <div class="comment-created-at">
          {{ comment.created_at }}
        </div>

        <form
          action="/article/comment/delete"
          method="get"
          class="comment-delete"
        >
          <input type="hidden" name="_token" :value="csrf" />
          <input
            type="hidden"
            name="comment_id"
            :value="comment.id" 
          >
          <button
            class="comment-delete" 
            onclick="return 
            confirm('削除しますか？');"
            v-if="comment.user.id === auth.id "
          >
          削除
          </button>
        </form>
      
      </li>
      <li class="comment-body">
        {{  comment.body }}
      </li>

     
      <!-- ここからリプライ -->
    <template v-for="(replies,index) in comment.replies ">
      <div class="reply-box">
        <div class="reply-user-data">

         <router-link 
           :to="{name: 'userpage',
           query: {userId: replies.user.id}}"
           v-if="replies.user.id !== auth.id"
         >
             <img :src="replies.user.profile_image" class="show-user-image">

        </router-link>

    <a @click.stop.prevent="goUrlPage('/mypage/show')"
      v-if="replies.user.id === auth.id"
    >
       <img class="top-article-myimage"
       :src="replies.user.profile_image">
    </a>
        
         
        <form
          action="/article/reply/delete"
          method="get"
          class="reply-delete" 
        >
          <input type="hidden" name="_token" :value="csrf" />
          <input
            type="hidden"
            name="reply_id"
            :value="replies.id" 
          >
          <button
            class="reply-delete"  
            onclick="return 
            confirm('削除しますか？');"
            v-if="replies.user.id === auth.id "
          >
          削除
          </button>
        </form>
      
        </div>
        
          <li class="replies">
            {{ replies.body }}
          </li>
      </div>    
    </template>
      
      <form 
      action="/article/reply" 
      class="reply-form"
      method="get"
      >
      <input type="hidden" name="_token" :value="csrf" />
        <div class="reply-sent-box">
          <input type="hidden" name="user_id"
          v-bind:value="auth.id">
          <input type="hidden" name="comment_id"
          v-bind:value="comment.id">
          <input type="hidden" name="article_id"
          v-bind:value="article.id">
          <textarea name="body" class="reply-textarea"
          placeholder="コメントを記入してください">
         
          </textarea>
          <button type="submit" class="reply-sent">
            返信する</button>
          </div>
      </form>
   
    </div>

  </template>
  
  </div>


  <h2 style=
      "background-color: #eee; 
       color: #333;
       width: 100%;
       height: 40px;
       text-align: left;
       font-size: 2.5rem;
       margin-left: 5%;
       margin-top: 60px;
      " 
       id="comment-h2">
       コメントする
  </h2>

  <ul id="error_message"></ul>
  <div class="show-border"></div>
    <form 
    action="/article/comment" 
    method="post"
    >
    <input type="hidden" name="_token" :value="csrf" />
      <div class="comment-write-box">
        <input type="hidden" name="user_id"
         v-bind:value="auth.id">
         <input type="hidden" name="article_id"
         v-bind:value="article.id">
         <textarea name="body" class="comment-textarea"
         placeholder="コメントを記入してください">
         
        </textarea>
        <button type="submit" id="comment-sent" class="comment-sent">
          コメント投稿</button>
        </div>
    </form>



</div>
</template>

<script>
import ArticleLike from '../../ArticleLike';

  export default {
 components: {
   ArticleLike,
 },
 data(){
    return{
    csrf: document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute("content"),
      
      article:  [],
      postUser: [],
      tag:      [],
      comments: [],
      article_parse_body: [],
    };
 },
   props: {
    auth:{
     type: Object|Array
    },
  },
  methods: {
    
    getArticleList(){
      const url = '/api/article/show/' + this.$route.query.articleId;

      this.$http.get(url)
      .then(response => {

        this.article  = response.data.article;
        this.tag      = response.data.article.tags;
        this.postUser = response.data.article.user;
        this.comments = response.data.comments;
        this.article_parse_body = response.data.article_parse_body

      }).catch(error => {
     console.log(error)
      });
    },
     goUrlPage(url) {
      this.$router.push(url);
  },
  },
  mounted() {
    this.getArticleList();
  },

 }
</script>