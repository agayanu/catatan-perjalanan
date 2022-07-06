<style>
.col-photo {
    flex: 0 0 auto;
    width: 13%;
}
.img-profile {
    max-width: 100%;
    height: auto;
    border-radius: 20%;
}
.profile-name {
    font-family: cursive;
    font-weight: bold;
    font-size: x-large;
}
.profile-nik {
    font-family: cursive;
    font-weight: bold;
    font-size: larger;
}
.btn-size-x {
    width: auto;
    margin-left: 11px;
}
.required {
    color: red;
    display: inline;
}
.spin {
    display: none;
    position: fixed;
    height: 4rem;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.show {
    display: block;
}
@media screen and (max-width: 576px) {
    .col-photo {
        flex: 0 0 auto;
        width: 100%;
        text-align: center;
    }
    .img-profile {
        max-width: 40%;
        height: auto;
    }
    .profile-name {
        text-align: center;
    }
    .profile-nik {
        text-align: center;
    }
    .btn-size-x {
        width: -webkit-fill-available;
        margin-left: unset;
    }
}
</style>
{{-- SweetAlert2 --}}
<script src="{{asset('sweetalert2/sweetalert2.all.min.js')}}"></script>