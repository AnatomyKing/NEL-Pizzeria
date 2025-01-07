using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace NELpizza.Model
{
    [Table("klants")]
    public class Klant
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long Id { get; set; }

        [Column("naam", TypeName = "VARCHAR(255)")]
        public string Naam { get; set; } = string.Empty;

        [Column("adres", TypeName = "VARCHAR(255)")]
        public string Adres { get; set; } = string.Empty;

        [Column("woonplaats", TypeName = "VARCHAR(255)")]
        public string Woonplaats { get; set; } = string.Empty;

        [Column("telefoonnummer", TypeName = "VARCHAR(255)")]
        public string Telefoonnummer { get; set; } = string.Empty;

        [Column("emailadres", TypeName = "VARCHAR(255)")]
        public string Emailadres { get; set; } = string.Empty;

        public virtual ICollection<Bestelling> Bestellingen { get; set; } = new HashSet<Bestelling>();
    }
}
