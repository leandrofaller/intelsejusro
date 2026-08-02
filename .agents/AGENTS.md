# Diretrizes do Projeto - intelsejusro_sipen

## Lembretes de Sincronização Local vs. Servidor
Sempre que o usuário interagir com você sobre este projeto, lembre-o de sincronizar manualmente as pastas de uploads que são ignoradas pelo Git.

### Pastas de Uploads para Sincronizar:
* `sipen/public/fotosPresos/`
* `sipen/public/documentos_Faccao/`
* `sipen/public/documentos_Apenado/`
* Outras subpastas de uploads em `sipen/public/`

### Como sincronizar rapidamente (via terminal local):
* **Fotos de Presos:**
  `scp -o StrictHostKeyChecking=no -P 65002 -r d:\AIP\intelsejusro_sipen\sipen\public\fotosPresos u923418691@82.180.175.4:domains/intelsejusro.com/public_html/sipen/public/`
* **Documentos de Facção:**
  `scp -o StrictHostKeyChecking=no -P 65002 -r d:\AIP\intelsejusro_sipen\sipen\public\documentos_Faccao u923418691@82.180.175.4:domains/intelsejusro.com/public_html/sipen/public/`
