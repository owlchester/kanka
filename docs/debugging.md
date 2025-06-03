# 🔎 Debugging

If you're having issues with your local instance, these two methods are your best bet.

## 🚩 Enable debug mode

If you're having 500 errors any of the app's URLs, try the following.

Enable debug mode by editing the `.env` file and replacing `APP_DEBUG=false` with `APP_DEBUG=true`. This will now show the error in the browser, which can give you a hint as to what went wrong.

## ❌ Check your error logs

If you want access to the detailed error logs, execute the following commands.

```bash
tail -f storage/logs/laravel-{date}.log
```
