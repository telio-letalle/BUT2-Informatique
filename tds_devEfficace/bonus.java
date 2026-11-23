// Exercice 1. Fusion (tri) de deux tableaux triés
int [] fusionTabTries (int [] t1, int [] t2) {
	// Pre-requis : t1 et t2 sont triés par ordre croissant
	int [] tabRes = new int [t1.length+t2.length];
	fusionTabTriesAux (t1, 0, t2, 0, tabRes, 0);
	return tabRes;
}

void fusionTabTriesAux (int [] t1, int i1, int [] t2, int i2, int [] tabRes,
int iRes) {
	// Pre-requis : tableaux t1 et t2 triés à partir de i1 et i2
	// respectivement,
	// 0 ≤ i1 ≤ t1.length, 0 ≤ i2 ≤ t2.length, 0 ≤ iRes ≤ tRes.length,
	// tabRes.length - iRes = (t1.length - i1) + (t2.length - i2)
	//
	// Action : remplit tabRes à partir de l’indice iRes, avec les
	// valeurs des sous-tableaux t1[i1..(t1.length-1)] et
	// t2[i2..(t2.length-1)] triées par ordre croissant

	if (i1 == t1.length || i2 == t2.length) {
		if (i1 == t1.length) {
			tabRes[iRes] = t2[i2];
			fusionTabTriesAux(t1, i1, t2, i2 + 1, tabRes, iRes + 1);
		} else if (i2 == t2.length) {
                        tabRes[iRes] = t1[i1];
                        fusionTabTriesAux(t1, i1 + 1, t2, i2, tabRes, iRes + 1);
                } else {
			if (t1[i1] > t2[i2]) {
				tabRes[iRes] = t2[i2];
    	                    	fusionTabTriesAux(t1, i1, t2, i2 + 1, tabRes, iRes + 1);
			} else {
				tabRes[iRes] = t1[i1];
                        	fusionTabTriesAux(t1, i1 + 1, t2, i2, tabRes, iRes + 1);
			}
		}
	}
}
