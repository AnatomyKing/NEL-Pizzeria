using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("klants")]
    public class Klant
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long id { get; set; }

        [Column("naam", TypeName = "VARCHAR(255)")]
        public string naam { get; set; } = string.Empty;

        [Column("adres", TypeName = "VARCHAR(255)")]
        public string adres { get; set; } = string.Empty;

        [Column("woonplaats", TypeName = "VARCHAR(255)")]
        public string woonplaats { get; set; } = string.Empty;

        [Column("telefoonnummer", TypeName = "VARCHAR(255)")]
        public string telefoonnummer { get; set; } = string.Empty;

        [Column("emailadres", TypeName = "VARCHAR(255)")]
        public string emailadres { get; set; } = string.Empty;

        public virtual ICollection<Bestelling> bestellingen { get; set; } = new HashSet<Bestelling>();
    }
}

