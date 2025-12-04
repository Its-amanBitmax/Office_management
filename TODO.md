# TODO: Fix MulterError in WhatsApp Bot

## Steps to Complete
- [x] Change multer setup to use upload.any() instead of upload.single('media') in all routes
- [x] Update /send route handler to use req.files[0] instead of req.file
- [x] Update /send-bulk route handler to use req.files[0] instead of req.file
- [x] Update /send-group route handler to use req.files[0] instead of req.file
- [x] Update /send-media route handler to use req.files[0] instead of req.file
- [x] Ensure file cleanup works with req.files[0].path in all handlers
