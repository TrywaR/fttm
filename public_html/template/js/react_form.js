class FTTMsForm extends React.Component {
  constructor(props) {
      super(props);
      this.state = {
        id: 0,
        table: 'add',
        action: '',
        user_id: 0,
        data: {},
        title: '',
        sort: '',
        active: false,
        submit: 'Submit',
      };

      this.handleChange = this.handleChange.bind(this);
      this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
      console.log('Change')
      // console.log(this.state)

      // console.log(event.target)
      // console.log(event.target.complete)
      console.log(event.target.checked)

      // this.setState({value: event.target.value});
      if ( this.state.title != event.target.value ) {
        console.log('Title change')
      }

      this.setState({
        title: event.target.value,
        active: event.target.complete,
        sort: event.target.value
      });
    }

    handleSubmit(event) {
      alert('Отправленное имя: ' + this.state.value);
      event.preventDefault();
    }

    render() {
      // const {id, table, action, user_id, data, title, active, submit} = this.props

      return (
        <form onSubmit={this.handleSubmit}>
          <input type="hidden" name="id" value="{this.state.id}" />
          <input type="hidden" name="table" value="{this.state.table}" />
          <input type="hidden" name="user_id" value="{this.state.user_id}" />
          <input type="hidden" name="action" value="{this.state.action}" />

          <div className="form-group row">
            <label htmlFor="input_title" className="col-sm-2 col-form-label">Title</label>
            <div className="col-sm-10">
              <input type="text" className="form-control" id="input_title" name="{this.state.title}" onChange={this.handleChange} />
            </div>
          </div>

          <div className="form-group row">
            <label htmlFor="input_sort" className="col-sm-2 col-form-label">Sort</label>
            <div className="col-sm-10">
              <input type="number" className="form-control" id="input_sort" name="{this.state.sort}" onChange={this.handleChange} />
            </div>
          </div>

          <div className="form-check">
            <input className="form-check-input" defaultChecked="{this.state.active}" type="checkbox" id="input_active" name="active" onChange={this.handleChange} />
            <label className="form-check-label" htmlFor="input_active">
              Active
            </label>
          </div>

          <div className="form-group">
            <label htmlFor="input_description">description</label>
            <textarea className="form-control" id="input_description" rows="3"></textarea>
          </div>

          <button type="submit" className="btn btn-primary">{this.state.submit}</button>
        </form>
      );
    }
}
