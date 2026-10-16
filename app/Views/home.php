<?= $this->extend('layout') ?>

<?= $this->section('content') ?>


<style>
body { overflow: hidden; }
main { max-width: none; margin: 0; padding: 0; }

#imagen { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; object-fit: fill; z-index: -1; }

.subtitulo { position: fixed; left: 13vw; top: 56vh; width: 24vw; margin: 0; font-family: Georgia, serif; font-style: italic; font-size: 1.4vw; line-height: 1.4; color: #853953; }
</style>


<img id="imagen" src="<?= base_url('img/et.png') ?>" alt="Pendi">


<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
gsap.from("#imagen", { opacity: 0, duration: 1.2 });
gsap.from(".bloque", { x: 200, opacity: 0, duration: 1, delay: 0.5 });
gsap.from(".subtitulo", { y: 20, opacity: 0, duration: 1, delay: 1 });
</script>
<?= $this->endSection() ?>