<div class="col-12 col-md-6 mb-4" style="display:none;">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">
        React form
      </h4>

      <div id="FTTMForm"></div>

      <!-- https://ru.reactjs.org/docs/faq-ajax.html -->

      <script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
      <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
      <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
      <script type="text/babel" src="/template/js/react_form.js"></script>
      <script type="text/babel">
        ReactDOM.render(
          <FTTMsForm />,
          document.querySelector('#FTTMForm')
        );
        // console.log($(FTTMForm).html())
      </script>
    </div>
  </div>
</div>
