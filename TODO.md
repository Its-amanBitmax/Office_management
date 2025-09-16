# Visitor Card Implementation TODO

## Tasks to Complete

- [x] Install "simple-qrcode" Laravel package for QR code generation
- [x] Add a new route for visitor card in routes/web.php
- [x] Add a new method in VisitorController.php for showing the visitor card
- [x] Create a new blade view resources/views/admin/visitors/card.blade.php for the visitor card with unique ID and QR code
- [x] Add a link/button in the visitor show.blade.php to access the visitor card
- [x] Test the visitor card generation and QR code display
- [x] Create migration for invited_visitors table
- [x] Create InvitedVisitor model
- [x] Create InvitedVisitorController with resource methods and card method
- [x] Create blade views for invited visitors (index, create, show, card)
- [x] Add routes for invited visitors
- [x] Update sidebar to link "Visitor Invites" to invited-visitors.index
- [x] Add invitation PDF generation method in InvitedVisitorController
- [x] Create invitation PDF blade view with visitor details and QR code
- [x] Add route for invitation PDF download
- [x] Add "Download Invitation PDF" button in invited visitor show page
- [x] Fix QR code display in PDF by generating PNG base64 image instead of SVG
