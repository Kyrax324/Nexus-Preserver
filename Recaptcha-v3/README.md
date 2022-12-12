# Recaptcha

## Installation
```bash
npm install vue-recaptcha-v3@^1.9.0
```
## Usage
`.env` / `.env.example`
```
RECAPTCHA_SITE_KEY= <site key>
RECAPTCHA_SECRET= <secret key>
```

service.php config
```php
 'recaptcha' => [
        'key' => env('RECAPTCHA_SITE_KEY'),
        'secret' => env('RECAPTCHA_SECRET'),
    ],
```

main.js
```js
import Vue from 'vue'
import { VueReCaptcha } from 'vue-recaptcha-v3'

Vue.use(VueReCaptcha, {
	siteKey: '<site key>' ,
	loaderOptions: {
		autoHideBadge: true
	}
})
```

front page (example vue contactPage.vue)
```html
<v-btn
    @click="submitForm(form)"
>
    Submit
</v-btn>
```

```js
mounted(){
		this.initRecaptcha();
},

methods:{
		async initRecaptcha(){
			await this.$recaptchaLoaded()
		},
		async submitForm(item){
			// Execute reCAPTCHA with action "submit".
			const token = await this.$recaptcha('submit')
			this.form.recaptcha = token

			this.submitData(item);
		},

submitData(item){
    let payload = item
    this.loading = true;
    this.errors = {}

    BaseClient.sendMail(payload).then((res) => {
        this.$toast.success(res.data.message)
        let result = res.data.data
    }).catch((err) => {
       // error handling
    }).finally(()=>{
        this.loading = false;
    })
},

```
Validation
```php
  public function rules()
    {
        return [
            'recaptcha' => ['required', new Recaptcha()],
        ];
    }
```


### 
[Recaptcha.php ](/Recaptcha-v3/Rules/Recaptcha.php)