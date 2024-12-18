using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("Klant")]
    public class Klant
    {
        [Key]
        public int KlantID { get; set; }

        public string Naam { get; set; }
        public string Adres { get; set; }
        public string Woonplaats { get; set; }
        public string Telefoonnummer { get; set; }
        public string Emailadres { get; set; }

        // Navigation Property
        public virtual ICollection<Bestelling> Bestellingen { get; set; }
    }
}
